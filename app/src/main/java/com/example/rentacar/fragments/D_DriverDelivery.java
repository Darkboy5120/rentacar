package com.example.rentacar.fragments;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceSpinner;
import com.example.rentacar.models.StorageManager;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class D_DriverDelivery extends Fragment implements View.OnClickListener,
        AdapterView.OnItemSelectedListener {
    LinearLayout ll_spn_global, ll_carsDriver;
    NiceSpinner ns_phase_driver;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_d_driver_delivery, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_d_driver_delivery_title);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        ll_carsDriver = view.findViewById(R.id.layout_carsDriver);
        view.findViewById(R.id.layout_container_driver).setOnClickListener(this);

        ns_phase_driver = new NiceSpinner(R.id.label_et_phase_driver, R.id.et_phase_driver, R.id.help_et_phase_driver,
                R.id.log_et_phase_driver, false, requireView(), this);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container_driver) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        }
    }

    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        if (parent.getId() == R.id.et_phase_driver) {
            make_search_in_server(new StorageManager(requireContext()).getString("user_id"),
                    Integer.toString(position));
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> parent) {

    }

    public String use_finalprice_template(String price) {
        return getResources().getString(R.string.label_tv_rented_car_finalprice) + " "
                + getResources().getString(R.string.label_tv_price_simbol) + price
                + " " + getResources().getString(R.string.label_tv_price_extra_simple);
    }

    public void make_search_in_server(String user_id, String phase) {
        ll_spn_global.setVisibility(View.VISIBLE);

        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Global.apis_path,
                response -> {
                    try {
                        ll_spn_global.setVisibility(View.GONE);
                        ll_carsDriver.removeAllViews();
                        JSONObject json = new JSONObject(response);
                        Log.d("foo", json.toString());
                        String code = json.getString("code");
                        if (code.equals("0")) {
                            requireView().findViewById(R.id.cars_empty_driver).setVisibility(View.INVISIBLE);
                            JSONObject data = json.getJSONObject("data");
                            JSONArray cars = data.getJSONArray("cars");
                            View car_card;
                            JSONObject row;
                            for (int i = 0; i < cars.length(); i++) {
                                row = cars.getJSONObject(i);
                                car_card = LayoutInflater.from(requireContext()).inflate(
                                        R.layout.component_simple_cardcard, ll_carsDriver, false);

                                //car values
                                String delivery_phase = row.getString("fase");
                                String car_id = row.getString("pk_auto");
                                String image_path = Global.domain_name + row.getString("imagen_ruta").substring(5);
                                String car_final_price = use_finalprice_template(
                                        row.getString("costo")
                                );
                                String car_name = row.getString("marca_nombre") + " "
                                        + row.getString("modelo_nombre");
                                String car_startdate = getResources().getString(R.string.label_tv_rented_car_startdate) + " "
                                        + row.getString("fechahora_entrega");
                                String car_enddate = getResources().getString(R.string.label_tv_rented_car_enddate) + " "
                                        + row.getString("fechahora_devolucion");
                                String pk_renta = row.getString("pk_renta");

                                if (delivery_phase.equals("0") || delivery_phase.equals("2") || delivery_phase.equals("4")) {
                                    //add onclic to update phase
                                    car_card.setOnClickListener(v -> {
                                        try_rent_update(pk_renta,
                                                new StorageManager(requireContext()).getString("user_id"),
                                                phase);
                                    });
                                } else {
                                    //onclick only will display an error message
                                    car_card.setOnClickListener(v -> {
                                        Global.printMessage(requireView(), getResources().getString(R.string.error_user_first));
                                    });
                                    //also add a message in the card to let the user know that the card
                                    //can be clicked
                                    TextView tv_driver_msg = car_card.findViewById(R.id.car_driver_msg);
                                    switch (delivery_phase) {
                                        case "1":
                                            tv_driver_msg.setText(R.string.label_tv_driver_delivery);
                                            tv_driver_msg.setVisibility(View.VISIBLE);
                                            break;
                                        case "3":
                                            tv_driver_msg.setText(R.string.label_tv_delivery_end);
                                            tv_driver_msg.setVisibility(View.VISIBLE);
                                            break;
                                    }
                                }

                                //update view values
                                Global.setImage(image_path, car_card.findViewById(R.id.car_image));
                                ((TextView) car_card.findViewById(R.id.car_name))
                                        .setText(car_name);
                                ((TextView) car_card.findViewById(R.id.car_final_price))
                                        .setText(car_final_price);
                                ((TextView) car_card.findViewById(R.id.car_startdate))
                                        .setText(car_startdate);
                                ((TextView) car_card.findViewById(R.id.car_enddate))
                                        .setText(car_enddate);

                                ll_carsDriver.addView(car_card);
                            }
                        } else if (code.equals("-2")) {
                            requireView().findViewById(R.id.cars_empty_driver ).setVisibility(View.VISIBLE);
                        } else {
                            Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request));
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                },
                error -> Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request))) {
            @Override
            public Map<String, String> getParams()  {
                HashMap<String, String> headers = new HashMap<>();
                headers.put("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
                headers.put("api", "get_requested_cars");
                headers.put("securitykey", Global.security_key);
                headers.put("user_id", user_id);
                headers.put("fase", phase);
                return headers;
            }
        };
        queue.add(stringRequest);
    }
    public void ItsAllright(){
        AlertDialog.Builder alertadd = new AlertDialog.Builder(getContext())
                //¿Se entregó el auto correctamente?
                .setMessage(getResources().getString(R.string.report_question))
                //No
                .setPositiveButton(R.string.report_no, new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {

                    }
                })
                //Si
                .setNegativeButton(R.string.report_yes, new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                    }
                });
        alertadd.show();
    }

    public void try_rent_update(String pk_renta, String user_id, String phase) {
        ll_spn_global.setVisibility(View.VISIBLE);

        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Global.apis_path,
                response -> {
                    try {
                        ll_spn_global.setVisibility(View.GONE);
                        JSONObject json = new JSONObject(response);
                        Log.d("foo", json.toString());
                        String code = json.getString("code");
                        if (code.equals("0")) {
                            make_search_in_server(user_id, phase);
                            Global.printMessage(requireView(), getResources().getString(R.string.get_back_car));
                            if (code.equals(3)){
                                ItsAllright();
                            }
                        } else {
                            Global.printMessage(requireView(), getResources().getString(R.string.error_user_first));
                        }
                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                },
                error -> Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request))) {
            @Override
            public Map<String, String> getParams()  {
                HashMap<String, String> headers = new HashMap<>();
                headers.put("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
                headers.put("api", "update_rent_phase");
                headers.put("securitykey", Global.security_key);
                headers.put("fk_arrendatario", user_id);
                headers.put("pk_renta", pk_renta);
                return headers;
            }
        };
        queue.add(stringRequest);
    }
}