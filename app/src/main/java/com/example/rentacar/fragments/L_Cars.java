package com.example.rentacar.fragments;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
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

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class L_Cars extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global, ll_cars;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_cars, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_l_cars_title);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        ll_cars = view.findViewById(R.id.layout_cars);
        view.findViewById(R.id.layout_container).setOnClickListener(this);

        get_search_data();
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        }
    }

    public void get_search_data() {
        Intent i = requireActivity().getIntent();
        make_search_in_server(
                i.getStringExtra("minprice"),
                i.getStringExtra("maxprice"),
                i.getStringExtra("startlocation_latitude"),
                i.getStringExtra("startlocation_longitude"),
                i.getStringExtra("startdate"),
                i.getStringExtra("starttime"),
                i.getStringExtra("endlocation_latitude"),
                i.getStringExtra("endlocation_longitude"),
                i.getStringExtra("enddate"),
                i.getStringExtra("endtime")
        );
    }

    public String use_price_template(String price) {
        return getResources().getString(R.string.label_tv_price_simbol) + price
                + getResources().getString(R.string.label_tv_price_extra);
    }

    public void open_details_fragment(String image_path, String car_price, String car_name,
                                      String car_doors, String car_chairs) {
        Bundle bundle = new Bundle();
        bundle.putString("imagen_ruta", image_path);
        bundle.putString("precio", car_price);
        bundle.putString("nombre", car_name);
        bundle.putString("puertas", car_doors);
        bundle.putString("asientos", car_chairs);

        L_Details fragment = new L_Details();
        fragment.setArguments(bundle);

        getActivity().getSupportFragmentManager().beginTransaction()
                .replace(((ViewGroup)getView().getParent()).getId(), fragment)
                .addToBackStack(null)
                .commit();
    }

    public void make_search_in_server(String minprice, String maxprice, String startlocation_latitude,
                                      String startlocation_longitude, String startdate, String starttime,
                                      String endlocation_latitude, String endlocation_longitude,
                                      String enddate, String endtime) {
        ll_spn_global.setVisibility(View.VISIBLE);

        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Global.apis_path,
                response -> {
                    try {
                        ll_spn_global.setVisibility(View.GONE);
                        Log.d("foo", response);
                        JSONObject json = new JSONObject(response);
                        String code = json.getString("code");
                        if (code.equals("0")) {
                            JSONObject data = json.getJSONObject("data");
                            JSONArray cars = data.getJSONArray("cars");
                            View car_card;
                            JSONObject row;
                            for (int i = 0; i < cars.length(); i++) {
                                row = cars.getJSONObject(i);
                                car_card = LayoutInflater.from(requireContext()).inflate(
                                        R.layout.component_cardcar, ll_cars, false);

                                //car values
                                String image_path = Global.domain_name + row.getString("imagen_ruta").substring(5);
                                String car_price = use_price_template(
                                        row.getString("precio")
                                );
                                String car_transmission = (row.getString("transmicion").equals("0"))
                                        ? getResources().getString(R.string.label_tv_transmission_auto)
                                        : getResources().getString(R.string.label_tv_transmission_manual);
                                String car_name = row.getString("marca_nombre") + " "
                                        + row.getString("modelo_nombre");
                                String car_doors = row.getString("puertas") + " "
                                        + getResources().getString(R.string.label_tv_doors);
                                String car_chairs = row.getString("asientos") + " "
                                        + getResources().getString(R.string.label_tv_chairs);

                                //update view values
                                Global.setImage(image_path, car_card.findViewById(R.id.car_image));
                                ((TextView) car_card.findViewById(R.id.car_price))
                                        .setText(car_price);
                                ((TextView) car_card.findViewById(R.id.car_transmission))
                                        .setText(car_transmission);
                                ((TextView) car_card.findViewById(R.id.car_name))
                                        .setText(car_name);

                                car_card.setOnClickListener(v -> {
                                    open_details_fragment(image_path, car_price, car_name, car_doors,
                                            car_chairs);
                                });
                                ll_cars.addView(car_card);
                            }
                        } else if (code.equals("-3")) {
                            requireView().findViewById(R.id.cars_empty).setVisibility(View.VISIBLE);
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
                headers.put("api", "get_filtered_cars");
                headers.put("securitykey", Global.security_key);
                headers.put("offset", "0");
                headers.put("limit", "15");
                headers.put("minprice", minprice);
                headers.put("maxprice", maxprice);
                headers.put("startlocation_latitude", startlocation_latitude);
                headers.put("startlocation_longitude", startlocation_longitude);
                headers.put("startdate", startdate);
                headers.put("starttime", starttime);
                headers.put("endlocation_latitude", endlocation_latitude);
                headers.put("endlocation_longitude", endlocation_longitude);
                headers.put("enddate", enddate);
                headers.put("endtime", endtime);
                return headers;
            }
        };
        queue.add(stringRequest);
    }
}
