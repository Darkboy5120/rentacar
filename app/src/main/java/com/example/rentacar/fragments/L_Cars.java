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
                i.getStringExtra("startdatetime"),
                i.getStringExtra("endlocation_latitude"),
                i.getStringExtra("endlocation_longitude"),
                i.getStringExtra("enddatetime")
        );
    }

    public String use_price_template(String price) {
        return getResources().getString(R.string.label_tv_price_simbol) + price
                + getResources().getString(R.string.label_tv_price_extra);
    }

    public String use_storage_size_template(String storage_size) {
        if (storage_size.equals("0")) {
            return getResources().getString(R.string.label_tv_storage_size_none);
        }
        String storage_size_human = "";
        switch (storage_size) {
            case "1":
                storage_size_human = getResources().getString(R.string.label_tv_storage_size_1);
                break;
            case "2":
                storage_size_human = getResources().getString(R.string.label_tv_storage_size_2);
                break;
            case "3":
                storage_size_human = getResources().getString(R.string.label_tv_storage_size_3);
                break;
        }
        return getResources().getString(R.string.label_tv_storage_size) + " "
                + storage_size_human;
    }

    public String use_engine_template(String car_engine) {
        String r = "";
        switch (car_engine) {
            case "0":
                r = getResources().getString(R.string.label_tv_engine_type_0);
                break;
            case "1":
                r = getResources().getString(R.string.label_tv_engine_type_1);
                break;
            case "2":
                r = getResources().getString(R.string.label_tv_engine_type_2);
                break;
            case "3":
                r = getResources().getString(R.string.label_tv_engine_type_3);
                break;
            case "4":
                r = getResources().getString(R.string.label_tv_engine_type_4);
                break;
            case "5":
                r = getResources().getString(R.string.label_tv_engine_type_5);
                break;
        }
        return r;
    }

    public void open_details_fragment(String car_id, String image_path, String car_price, String car_name,
                                      String car_doors, String car_chairs, String car_storage_size,
                                      String car_transmission, String car_engine,
                                      String car_fuel_unit, String car_horse_power,
                                      String car_tank_capacity, String car_color, String car_air,
                                      String car_gps, String car_polarized_glasses,
                                      String car_insurance, String car_replacement_wheel,
                                      String car_toolbox, String price_raw) {
        Bundle bundle = new Bundle();
        bundle.putString("pk_auto", car_id);
        bundle.putString("imagen_ruta", image_path);
        bundle.putString("precio", car_price);
        bundle.putString("nombre", car_name);
        bundle.putString("puertas", car_doors);
        bundle.putString("asientos", car_chairs);
        bundle.putString("capacidad_cajuela", car_storage_size);
        bundle.putString("transmicion", car_transmission);
        bundle.putString("tipo_motor", car_engine);
        bundle.putString("unidad_consumo", car_fuel_unit);
        bundle.putString("caballos_fuerza", car_horse_power);
        bundle.putString("capacidad_combustible", car_tank_capacity);
        bundle.putString("fk_auto_color_pintura", car_color);
        bundle.putString("aire_acondicionado", car_air);
        bundle.putString("gps", car_gps);
        bundle.putString("vidrios_polarizados", car_polarized_glasses);
        bundle.putString("seguro", car_insurance);
        bundle.putString("repuesto", car_replacement_wheel);
        bundle.putString("caja_herramientas", car_toolbox);
        bundle.putString("precio_raw", price_raw);

        L_Details fragment = new L_Details();
        fragment.setArguments(bundle);

        getActivity().getSupportFragmentManager().beginTransaction()
                .replace(((ViewGroup)getView().getParent()).getId(), fragment)
                .addToBackStack(null)
                .commit();
    }

    public void make_search_in_server(String minprice, String maxprice, String startlocation_latitude,
                                      String startlocation_longitude, String startdatetime,
                                      String endlocation_latitude, String endlocation_longitude,
                                      String enddatetime) {
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
                            JSONObject data = json.getJSONObject("data");
                            JSONArray cars = data.getJSONArray("cars");
                            View car_card;
                            JSONObject row;
                            for (int i = 0; i < cars.length(); i++) {
                                row = cars.getJSONObject(i);
                                car_card = LayoutInflater.from(requireContext()).inflate(
                                        R.layout.component_cardcar, ll_cars, false);

                                //car values
                                String car_id = row.getString("pk_auto");
                                String image_path = Global.domain_name + row.getString("imagen_ruta").substring(5);
                                String car_price = use_price_template(
                                        row.getString("precio")
                                );
                                String price_raw = row.getString("precio");
                                String car_name = row.getString("marca_nombre") + " "
                                        + row.getString("modelo_nombre");
                                String car_doors = row.getString("puertas") + " "
                                        + getResources().getString(R.string.label_tv_doors);
                                String car_chairs = row.getString("asientos") + " "
                                        + getResources().getString(R.string.label_tv_chairs);
                                String car_storage_size = use_storage_size_template(row.getString("capacidad_cajuela"));
                                String car_engine = use_engine_template(row.getString("tipo_motor"));
                                String car_transmission = (row.getString("transmicion").equals("0"))
                                        ? getResources().getString(R.string.label_tv_transmission_auto)
                                        : getResources().getString(R.string.label_tv_transmission_manual);
                                String car_fuel_unit = row.getString("unidad_consumo") + " "
                                        + getResources().getString(R.string.label_tv_fuel_unit);
                                String car_horse_power = row.getString("caballos_fuerza") + " "
                                        + getResources().getString(R.string.label_tv_horse_power);
                                String car_tank_capacity = getResources().getString(R.string.label_tv_tank_capacity_start)
                                        + " " + row.getString("capacidad_combustible") + " "
                                        + getResources().getString(R.string.label_tv_tank_capacity_extra);
                                String car_color = getResources().getString(R.string.label_tv_color)
                                        + " " + getResources().getStringArray(R.array.arr_car_colors)[
                                            Integer.parseInt(row.getString("fk_auto_color_pintura"))
                                        ];
                                String car_air = row.getString("aire_acondicionado");
                                String car_gps = row.getString("gps");
                                String car_polarized_glasses = row.getString("vidrios_polarizados");
                                String car_insurance = getResources().getString(R.string.label_tv_insurance)
                                        + " " + getResources().getStringArray(R.array.arr_car_insurance)[
                                        Integer.parseInt(row.getString("seguro"))
                                        ];
                                String car_replacement_wheel = row.getString("repuesto");
                                String car_toolbox = row.getString("caja_herramientas");

                                //update view values
                                Global.setImage(image_path, car_card.findViewById(R.id.car_image));
                                ((TextView) car_card.findViewById(R.id.car_price))
                                        .setText(car_price);
                                ((TextView) car_card.findViewById(R.id.car_transmission))
                                        .setText(car_transmission);
                                ((TextView) car_card.findViewById(R.id.car_name))
                                        .setText(car_name);

                                car_card.setOnClickListener(v -> {
                                    open_details_fragment(car_id, image_path, car_price, car_name, car_doors,
                                            car_chairs, car_storage_size, car_transmission, car_engine,
                                            car_fuel_unit, car_horse_power, car_tank_capacity,
                                            car_color, car_air, car_gps, car_polarized_glasses,
                                            car_insurance, car_replacement_wheel, car_toolbox,
                                            price_raw);
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
                headers.put("startdatetime", startdatetime);
                headers.put("endlocation_latitude", endlocation_latitude);
                headers.put("endlocation_longitude", endlocation_longitude);
                headers.put("enddatetime", enddatetime);
                return headers;
            }
        };
        queue.add(stringRequest);
    }
}
