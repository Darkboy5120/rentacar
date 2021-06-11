package com.example.rentacar.fragments;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.LinearLayout;
import android.widget.RatingBar;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceFileInput;
import com.example.rentacar.models.NiceInput;
import com.example.rentacar.models.StorageManager;
import com.example.rentacar.models.VolleyMultipartRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class L_RatingCar extends Fragment implements View.OnClickListener,
        AdapterView.OnItemSelectedListener {
    LinearLayout ll_spn_global;
    RatingBar rb_user;
    NiceInput ni_comments;

    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_rating_car, container, false);
    }

    @Override
    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.rating_name_activity);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        rb_user = view.findViewById(R.id.user_rating);
        rb_user.setOnClickListener(this);
        view.findViewById(R.id.save).setOnClickListener(this);
        view.findViewById(R.id.layout_container_rating).setOnClickListener(this);
        ni_comments = new NiceInput("text", R.id.label_et_rate_description, R.id.et_rate_description,
                R.id.help_et_rate_description,  R.id.log_et_rate_description, "^[A-Za-z-ZÀ-ÿ-\u00f1\u00d1\\s']+", 15,
                255, false, requireView());
        get_id_data();
    }

    public void setArguments(Bundle bundle) {
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        } else if (vId == R.id.save) {
            send_info();
        }else if(vId == R.id.user_rating){
            float rb_value = rb_user.getRating();
            System.out.println("--------------------------------"+rb_value);
        }
    }

    public void send_info() {
        Global.hideKeyboardFrom(requireContext(), requireView());
        if (!submit_validate())
            return;
    }

    public void upload_rating(String carId) {
        ll_spn_global.setVisibility(View.VISIBLE);
        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Global.apis_path,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            Log.d("f",response.toString());
                            Log.d("shale",carId);
                            JSONObject json = new JSONObject(response);
                            String code = json.getString("code");
                            if (code.equals("0")) {
                                Global.printMessage(requireView(), getResources().getString(R.string.rate_success));
                            }else{
                                Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request));
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
                //NOMBRE DEL ARCHIVO PHP PARA MANDAR LA INFORMACION
                headers.put("api", "create_rating");
                headers.put("fk_arrendatario", new StorageManager(requireContext()).getString("user_id"));
                headers.put("fk_auto", carId);
                headers.put("securitykey", Global.security_key);
                headers.put("puntuacion", rb_user.getRating()+"");
                headers.put("comentarios",ni_comments.isEmpty(requireView()) ? "" : ni_comments.getValue(requireView()));
                return headers;
            }
        };
        queue.add(stringRequest);
    }

    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        if (parent.getId() == R.id.user_rating) {
            rb_user.getRating();
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> adapterView) {

    }

    public boolean submit_validate() {
        boolean result = true;

        return result;
    }

    public void get_id_data() {
        Intent i = requireActivity().getIntent();
        upload_rating(i.getStringExtra("carId"));
    }

}
