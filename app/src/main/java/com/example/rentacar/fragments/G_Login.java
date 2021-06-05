package com.example.rentacar.fragments;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;

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
import com.example.rentacar.models.NiceInput;
import com.example.rentacar.models.StorageManager;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class G_Login extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;
    NiceInput ni_email, ni_password;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_g_login, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_login_label);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);

        //((EditText) view.findViewById(R.id.et_email)).addTextChangedListener(new MaskWatcher("####-####"));;
        view.findViewById(R.id.signIn).setOnClickListener(this);
        view.findViewById(R.id.to_register).setOnClickListener(this);

        ni_email = new NiceInput("text", R.id.label_et_email, R.id.et_email,
                R.id.help_et_email,  R.id.log_et_email,
                "^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\\.[a-zA-Z0-9-]+)*$",
                5, 50, false, requireView());
        ni_password = new NiceInput("password", R.id.label_et_password, R.id.et_password,
                R.id.help_et_password,  R.id.log_et_password, "^[A-Za-z0-9]+", 5,
                50, false, requireView());

        StorageManager sm = new StorageManager(requireContext());
        String user_type = sm.getString("user_type");
        String user_id = sm.getString("user_id");

        if (!user_type.isEmpty() && !user_id.isEmpty()) {
            Intent i;
            switch (user_type) {
                case "l":
                    i = new Intent(requireActivity(), L_Home.class);
                    i.putExtra("user_id", user_id);
                    startActivity(i);
                    requireActivity().finish();
                    break;
                case "d":
                    i = new Intent(requireActivity(), com.example.rentacar.activities.D_DriverDelivery.class);
                    i.putExtra("user_id", user_id);
                    startActivity(i);
                    requireActivity().finish();
                    break;
            }
        }
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.signIn) {
            signIn();
        } else if (vId == R.id.to_register) {
            /*NavHostFragment.findNavController(com.example.rentacar.fragments.G_Login.this)
                    .navigate(R.id.action_FragmentLogin_to_FragmentRegister);*/
            Intent i = new Intent(requireActivity(), L_Register.class);
            startActivity(i);
        }
    }

    public void next_activity(String user_id, String user_type) {
        StorageManager sm = new StorageManager(requireContext());
        sm.setString("user_type", (user_type.equals("1") ? "l" : "d"));
        sm.setString("user_id", user_id);
        Intent i = null;
        switch (user_type){
            case "l":
                i = new Intent(requireActivity(), L_Home.class);
                break;
            case "d":
                i = new Intent(requireActivity(), D_DriverDelivery.class);
        }
        startActivity(i);
        requireActivity().finish();
    }

    public boolean signIn_validate() {
        boolean result = true;

        NiceInput[] ni_arr = {ni_email, ni_password};
        for (NiceInput nice_input : ni_arr) {
            if (!nice_input.validate(requireView())) {
                result = false;
            }
        }

        return result;
    }

    public void signIn() {
        if (!signIn_validate()) return;
        server_validate();
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
                                JSONObject data = json.getJSONObject("data");
                                String user_id = data.getString("pk_usuario");
                                String user_type = data.getString("tipo");
                                next_activity(user_id, user_type);
                            } else {
                                Global.printMessage(requireView(), getResources().getString(R.string.error_login_fail));
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
                headers.put("api", "login_lessee");
                headers.put("correo", ni_email.getValue(requireView()));
                headers.put("contraseña", ni_password.getValue(requireView()));
                return headers;
            }
        };
        queue.add(stringRequest);
    }
}