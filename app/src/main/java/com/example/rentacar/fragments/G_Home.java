package com.example.rentacar.fragments;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.activities.G_Login;
import com.example.rentacar.activities.L_Home;
import com.example.rentacar.activities.L_Register;
import com.example.rentacar.models.Global;

public class G_Home extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_g_home, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_g_home_title);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);

        view.findViewById(R.id.iamLessee).setOnClickListener(this);
        view.findViewById(R.id.iamDriver).setOnClickListener(this);
        view.findViewById(R.id.to_login).setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.iamLessee) {
            Intent i = new Intent(getActivity(), L_Register.class);
            startActivity(i);
        } else if (vId == R.id.iamDriver) {
            //Intent i = new Intent(getActivity(), L_Register.class);
            //startActivityForResult(i, 1);
        }
    }
}