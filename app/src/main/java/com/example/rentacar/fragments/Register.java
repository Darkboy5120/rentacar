package com.example.rentacar.fragments;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.LinearLayout;
import android.widget.Spinner;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.navigation.fragment.NavHostFragment;

import com.example.rentacar.R;

public class Register extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_register_step1, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        getActivity().setTitle(R.string.fragment_register_label);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);

        view.findViewById(R.id.signUp).setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.signIn) {
            signIn();
        }
    }

    public void signIn() {
        NavHostFragment.findNavController(com.example.rentacar.fragments.Register.this)
                .navigate(R.id.action_FragmentRegisterStep1_to_FragmentRegisterStep2);
        NavHostFragment.findNavController(com.example.rentacar.fragments.Register.this)
                .navigate(R.id.action_FragmentRegisterStep2_to_FragmentRegisterStep3);
        NavHostFragment.findNavController(com.example.rentacar.fragments.Register.this)
                .navigate(R.id.action_FragmentRegisterStep3_to_FragmentRegisterStep4);
    }
}