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
import com.example.rentacar.activities.L_Register;
import com.example.rentacar.models.Global;

public class G_Login extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;

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
        view.findViewById(R.id.layout_container).setOnClickListener(this);
        view.findViewById(R.id.et_email).setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        } else if (vId == R.id.signIn) {
            signIn();
        } else if (vId == R.id.to_register) {
            /*NavHostFragment.findNavController(com.example.rentacar.fragments.G_Login.this)
                    .navigate(R.id.action_FragmentLogin_to_FragmentRegister);*/
            Intent i = new Intent(getActivity(), L_Register.class);
            startActivity(i);
        }
    }

    public void signIn() {
        ll_spn_global.setVisibility(View.VISIBLE);

        // Instantiate the RequestQueue.
        RequestQueue queue = Volley.newRequestQueue(requireContext());
        String url = Global.apis_path;

        // Request a string response from the provided URL.
        StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        // Display the first 500 characters of the response string.
                        Global.printMessage(requireView(), "Response is: "+ response);
                        ll_spn_global.setVisibility(View.GONE);
                    }
                }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Global.printMessage(requireView(), Global.generic_error);
                        ll_spn_global.setVisibility(View.GONE);
                    }
        });

        // Add the request to the RequestQueue.
        queue.add(stringRequest);
    }
}