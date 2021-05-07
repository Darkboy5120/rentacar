package com.example.rentacar.fragments;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.navigation.fragment.NavHostFragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.models.CustomInterfaces;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceInput;
import com.example.rentacar.models.NiceSpinner;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;
import java.util.concurrent.Callable;

public class L_Register_Step2 extends Fragment implements View.OnClickListener, AdapterView.OnItemSelectedListener {
    LinearLayout ll_spn_global;
    NiceInput ni_email, ni_phone, ni_zip, ni_address;
    NiceSpinner ns_state, ns_city;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_register_step2, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_register_label);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        ll_spn_global.setVisibility(View.VISIBLE);

        view.findViewById(R.id.signUp).setOnClickListener(this);

        ni_email = new NiceInput("text", R.id.label_et_email, R.id.et_email,
                R.id.help_et_email,  R.id.log_et_email,
                "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\\.[a-zA-Z0-9-]+)*$",
                5, 50, false, requireView());
        ni_phone = new NiceInput("text", R.id.label_et_phone, R.id.et_phone,
                R.id.help_et_phone,  R.id.log_et_phone, "^[0-9]+", 10,
                10, false, requireView());
        ni_zip = new NiceInput("text", R.id.label_et_zip, R.id.et_zip,
                R.id.help_et_zip,  R.id.log_et_zip, "^[0-9]+", 5,
                5, false, requireView());
        ns_state = new NiceSpinner(R.id.label_et_state, R.id.et_state, R.id.help_et_state,
                R.id.log_et_state, false, requireView(), this);fill_states_spinner();
        ns_city = new NiceSpinner(R.id.label_et_city, R.id.et_city, R.id.help_et_city,
                R.id.log_et_city, false, requireView(), this);
        ni_address = new NiceInput("text", R.id.label_et_address, R.id.et_address,
                R.id.help_et_address,  R.id.log_et_address, "^[a-zA-Z0-9-\\s#,]*$", 15,
                50, false, requireView());
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.signUp) {
            signUp();
        }
    }

    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        try {
            JSONObject json = new JSONObject(ns_state.getTrauctorItem(position));
            JSONArray models = json.getJSONArray("cities");

            ArrayList<String> models_arr = new ArrayList<>();
            for (int i = 0; i < models.length(); i++) {
                JSONObject row = new JSONObject(models.getString(i));
                models_arr.add(row.getString("nombre"));
                ns_city.traductorPush(row.toString());
            }

            ns_city.setAdapter(requireView(), models_arr.toArray(new String[0]));
            ns_city.updateIndex(position);
            ll_spn_global.setVisibility(View.GONE);

        } catch (JSONException e) {
        }

    }

    @Override
    public void onNothingSelected(AdapterView<?> parent) {
    }

    public boolean signUp_validate() {
        boolean result = true;

        NiceInput[] ni_arr = {ni_email, ni_phone, ni_zip, ni_address};
        for (NiceInput nice_input : ni_arr) {
            if (!nice_input.validate(requireView())) {
                result = false;
            }
        }

        return result;
    }

    public void signUp() {
        if (!signUp_validate()) return;
        server_validate();
    }

    public Bundle get_form_values() {
        Bundle bundle = new Bundle();
        bundle.putString("firstname", getArguments().getString("firstname"));
        bundle.putString("lastname", getArguments().getString("lastname"));
        bundle.putString("birthdate", getArguments().getString("birthdate").replace("/", "-"));
        bundle.putString("password", getArguments().getString("password"));

        bundle.putString("email", ni_email.getValue(requireView()));
        bundle.putString("phone", ni_phone.getValue(requireView()));
        bundle.putString("zip", ni_zip.getValue(requireView()));
        bundle.putString("address", ni_address.getValue(requireView()));

        String city = "";
        try {
            JSONObject city_json = new JSONObject(ns_city.getTrauctorItem(ns_city.getIndex()));
            city = city_json.getString("pk_municipio");
        } catch (JSONException e) {
            e.printStackTrace();
        }

        bundle.putString("city", city);

        return bundle;
    }

    public void next_fragment() {
        L_Register_Step3 fragment = new L_Register_Step3();
        fragment.setArguments(get_form_values());

        getActivity().getSupportFragmentManager().beginTransaction()
                .replace(((ViewGroup)getView().getParent()).getId(), fragment)
                .addToBackStack(null)
                .commit();
    }

    public void server_validate() {
        ll_spn_global.setVisibility(View.VISIBLE);

        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Global.apis_path,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            ll_spn_global.setVisibility(View.GONE);
                            JSONObject json = new JSONObject(response);
                            String code = json.getString("code");
                            if (code.equals("0")) {
                                next_fragment();
                            } else {
                                ni_email.printLog(requireView(), getResources().getString(R.string.error_spn_duplicate_email));
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request));
                    }
                }) {
            @Override
            public Map<String, String> getParams()  {
                HashMap<String, String> headers = new HashMap<String, String>();
                headers.put("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
                headers.put("api", "validate_l_register_step2");
                headers.put("correo", ni_email.getValue(requireView()));
                return headers;
            }
        };
        queue.add(stringRequest);
    }

    public void fill_states_spinner() {
        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Global.apis_path,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject json = new JSONObject(response);
                            JSONArray data = json.getJSONArray("data");
                            String code = json.getString("code");
                            if (code.equals("0")) {
                                ArrayList<String> brands = new ArrayList<>();
                                for (int i = 0; i < data.length(); i++) {
                                    JSONObject row = new JSONObject(data.getString(i));
                                    brands.add(row.getString("nombre"));
                                    ns_state.traductorPush(row.toString());
                                }

                                ns_state.setAdapter(requireView(), brands.toArray(new String[0]));
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request));
                    }
                }) {
            @Override
            public Map<String, String> getParams()  {
                HashMap<String, String> headers = new HashMap<String, String>();
                headers.put("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
                headers.put("api", "get_states_cities");
                return headers;
            }
        };
        queue.add(stringRequest);
    }
}