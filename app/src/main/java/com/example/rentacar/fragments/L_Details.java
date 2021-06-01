package com.example.rentacar.fragments;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.core.content.res.ResourcesCompat;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceCollapse;
import com.example.rentacar.models.StorageManager;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

public class L_Details extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;
    NiceCollapse nc_car_spaces, nc_car_specs, nc_car_details, getNc_car_security;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_details, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_l_details_title);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        view.findViewById(R.id.layout_container).setOnClickListener(this);
        view.findViewById(R.id.rent).setOnClickListener(this);

        assert getArguments() != null;
        Global.setImage(getArguments().getString("imagen_ruta"),
                ((ImageView) requireView().findViewById(R.id.car_image)));
        ((TextView) requireView().findViewById(R.id.car_name))
                .setText(getArguments().getString("nombre"));
        ((TextView) requireView().findViewById(R.id.car_price))
                .setText(getArguments().getString("precio"));
        ((TextView) requireView().findViewById(R.id.car_doors))
                .setText(getArguments().getString("puertas"));
        ((TextView) requireView().findViewById(R.id.car_chairs))
                .setText(getArguments().getString("asientos"));
        ((TextView) requireView().findViewById(R.id.car_storage_size))
                .setText(getArguments().getString("capacidad_cajuela"));
        ((TextView) requireView().findViewById(R.id.car_transmission))
                .setText(getArguments().getString("transmicion"));
        ((TextView) requireView().findViewById(R.id.car_engine))
                .setText(getArguments().getString("tipo_motor"));
        ((TextView) requireView().findViewById(R.id.car_fuel_unit))
                .setText(getArguments().getString("unidad_consumo"));
        ((TextView) requireView().findViewById(R.id.car_horse_power))
                .setText(getArguments().getString("caballos_fuerza"));
        ((TextView) requireView().findViewById(R.id.car_tank_capacity))
                .setText(getArguments().getString("capacidad_combustible"));
        ((TextView) requireView().findViewById(R.id.car_color))
                .setText(getArguments().getString("fk_auto_color_pintura"));
        ((TextView) requireView().findViewById(R.id.car_air))
                .setCompoundDrawablesWithIntrinsicBounds(null,null,
                        get_car_icon(getArguments().getString("aire_acondicionado")),null);
        ((TextView) requireView().findViewById(R.id.car_gps))
                .setCompoundDrawablesWithIntrinsicBounds(get_car_icon(getArguments().getString("gps")),
                        null, null,null);
        ((TextView) requireView().findViewById(R.id.car_polarized_glasses))
                .setCompoundDrawablesWithIntrinsicBounds(null,null,
                        get_car_icon(getArguments().getString("vidrios_polarizados")),null);
        ((TextView) requireView().findViewById(R.id.car_insurance))
                .setText(getArguments().getString("seguro"));
        ((TextView) requireView().findViewById(R.id.car_replacement_wheel))
                .setCompoundDrawablesWithIntrinsicBounds(null,null,
                        get_car_icon(getArguments().getString("repuesto")),null);
        ((TextView) requireView().findViewById(R.id.car_toolbox))
                .setCompoundDrawablesWithIntrinsicBounds(get_car_icon(getArguments().getString("caja_herramientas")),
                        null, null,null);

        nc_car_spaces = new NiceCollapse(R.id.ll_c_spaces_trigger, R.id.ll_c_spaces_content, requireView());
        nc_car_specs = new NiceCollapse(R.id.ll_c_specs_trigger, R.id.ll_c_specs_content, requireView());
        nc_car_details = new NiceCollapse(R.id.ll_c_details_trigger, R.id.ll_c_details_content, requireView());
        getNc_car_security = new NiceCollapse(R.id.ll_c_security_trigger, R.id.ll_c_security_content, requireView());
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        } else if (vId == R.id.rent) {
            rent_car();
        }
    }

    public void rent_car() {
        Intent i = requireActivity().getIntent();
        Log.d("start", i.getStringExtra("startdatetime"));
        Log.d("end", i.getStringExtra("enddatetime"));
        String request_days = i.getStringExtra("request_days");
        long final_price = Long.parseLong(request_days) * Integer.parseInt(getArguments().getString("precio_raw"));

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
                        } else if (code.equals("-2")) {
                            Global.printMessage(requireView(), getResources().getString(R.string.error_already_rented));
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
                headers.put("api", "rent_car");
                headers.put("securitykey", Global.security_key);
                headers.put("user_id", new StorageManager(requireContext()).getString("user_id"));
                headers.put("car_id", getArguments().getString("pk_auto"));
                headers.put("final_price", Long.toString(final_price));
                headers.put("punto_entrega_latitud", i.getStringExtra("startlocation_latitude"));
                headers.put("punto_entrega_longitud", i.getStringExtra("startlocation_longitude"));
                headers.put("punto_devolucion_latitud", i.getStringExtra("endlocation_latitude"));
                headers.put("punto_devolucion_longitud", i.getStringExtra("endlocation_longitude"));
                headers.put("fechahora_entrega", i.getStringExtra("startdatetime"));
                headers.put("fechahora_devolucion", i.getStringExtra("enddatetime"));
                return headers;
            }
        };
        queue.add(stringRequest);
    }

    public Drawable get_car_icon(String value) {
        int drawable_id = (value.equals("0"))
                ? R.drawable.ic_baseline_close
                : R.drawable.ic_baseline_check;
        return getResources().getDrawable(drawable_id);
    }
}