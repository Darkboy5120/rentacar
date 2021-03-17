package com.example.rentacar.fragments;

import android.content.Intent;
import android.os.Bundle;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
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
import com.example.rentacar.activities.Register;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.MaskWatcher;

public class Login extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_login, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        getActivity().setTitle(R.string.fragment_login_label);
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
            Global.hideKeyboardFrom(getContext(), getView());
        } else if (vId == R.id.signIn) {
            signIn();
        } else if (vId == R.id.to_register) {
            /*NavHostFragment.findNavController(com.example.rentacar.fragments.Login.this)
                    .navigate(R.id.action_FragmentLogin_to_FragmentRegister);*/
            Intent i = new Intent(getActivity(), Register.class);
            startActivity(i);
        }
    }

    public void signIn() {
        ll_spn_global.setVisibility(View.VISIBLE);

        // Instantiate the RequestQueue.
        RequestQueue queue = Volley.newRequestQueue(requireContext());
        String url ="https://chilaquilesenterprise.com/cap/apis";

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
                        Global.printMessage(requireView(), "That didn't work!");
                        ll_spn_global.setVisibility(View.GONE);
                    }
        });

        // Add the request to the RequestQueue.
        queue.add(stringRequest);
    }
}