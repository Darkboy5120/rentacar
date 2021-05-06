package com.example.rentacar.fragments;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.navigation.fragment.NavHostFragment;

import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.activities.L_Home;
import com.example.rentacar.activities.L_Register;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceFileInput;
import com.example.rentacar.models.NiceInput;
import com.example.rentacar.models.VolleyMultipartRequest;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class L_Register_Step3 extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;
    NiceFileInput nfi_front, nfi_back;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_register_step3, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_register_label);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);

        view.findViewById(R.id.signUp).setOnClickListener(this);

        nfi_front = new NiceFileInput(R.id.label_et_front, R.id.status_et_front, R.id.btn_front,
                R.id.help_et_front, R.id.log_et_front, requireView(), requireActivity(),
                L_Register_Step3.this);
        nfi_back = new NiceFileInput(R.id.label_et_back, R.id.status_et_back, R.id.btn_back,
                R.id.help_et_back, R.id.log_et_back, requireView(), requireActivity(),
                L_Register_Step3.this);


    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        nfi_front.listenResult(requireActivity(), requireView(), requestCode, resultCode);
        nfi_back.listenResult(requireActivity(), requireView(), requestCode, resultCode);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.signUp) {
            signUp();
        }
    }

    public boolean signUp_validate() {
        boolean result = true;

        NiceFileInput[] ni_arr = {nfi_front, nfi_back};
        for (NiceFileInput nice_file_input : ni_arr) {
            if (!nice_file_input.validate(requireView())) {
                result = false;
            }
        }

        return result;
    }

    public void signUp() {
        if (!signUp_validate()) return;
        upload_info_to_server();
    }

    public void upload_info_to_server() {
        ll_spn_global.setVisibility(View.VISIBLE);

        VolleyMultipartRequest volleyMultipartRequest = new VolleyMultipartRequest(Request.Method.POST, Global.apis_path,
                new Response.Listener<NetworkResponse>() {
                    @Override
                    public void onResponse(NetworkResponse response) {
                        try {
                            ll_spn_global.setVisibility(View.GONE);
                            JSONObject json = new JSONObject(new String(response.data));
                            String code = json.getString("code");
                            if (code.equals("0")) {

                                String user_id = json.getString("data");

                                SharedPreferences settings = requireContext().getSharedPreferences("Preferences", Context.MODE_PRIVATE);
                                SharedPreferences.Editor editor = settings.edit();
                                editor.putString("user_type", "l");
                                editor.putString("last_user_id", user_id);
                                editor.apply();

                                Intent i = new Intent(requireActivity(), L_Home.class);
                                i.putExtra("user_id", user_id);
                                i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_NEW_TASK);
                                startActivity(i);
                                requireActivity().finish();
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
                headers.put("api", "signup_l_register");
                headers.put("nombre", getArguments().getString("firstname"));
                headers.put("apellido", getArguments().getString("lastname"));
                headers.put("fecha_nacimiento", getArguments().getString("birthdate"));
                headers.put("clave", getArguments().getString("password"));
                headers.put("correo", getArguments().getString("email"));
                headers.put("telefono", getArguments().getString("phone"));
                headers.put("codigo_postal", getArguments().getString("zip"));
                headers.put("direccion", getArguments().getString("address"));
                headers.put("municipio", getArguments().getString("city"));
                return headers;
            }

            @Override
            protected Map<String, DataPart> getByteData() {
                Map<String, VolleyMultipartRequest.DataPart> params = new HashMap<>();
                long imagename = System.currentTimeMillis();
                params.put("licencia_frontal", new DataPart("image0" + nfi_front.getFileType(), VolleyMultipartRequest.getFileDataFromDrawable(nfi_front.getFile())));
                params.put("licencia_posterior", new DataPart("image1" + nfi_front.getFileType(), VolleyMultipartRequest.getFileDataFromDrawable(nfi_front.getFile())));
                return params;
            }
        };
        Volley.newRequestQueue(requireContext()).add(volleyMultipartRequest);
    }
}