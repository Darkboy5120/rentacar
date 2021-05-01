package com.example.rentacar.fragments;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.navigation.fragment.NavHostFragment;

import com.example.rentacar.R;
import com.example.rentacar.models.Global;

public class L_Register extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_register_step1, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_register_label);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        view.findViewById(R.id.layout_container).setOnClickListener(this);

        view.findViewById(R.id.signUp).setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.signIn) {
            signIn();
        } else if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        }
    }

    public void signIn() {
        NavHostFragment.findNavController(L_Register.this)
                .navigate(R.id.action_FragmentRegisterStep1_to_FragmentRegisterStep2);
        NavHostFragment.findNavController(L_Register.this)
                .navigate(R.id.action_FragmentRegisterStep2_to_FragmentRegisterStep3);
        NavHostFragment.findNavController(L_Register.this)
                .navigate(R.id.action_FragmentRegisterStep3_to_FragmentRegisterStep4);
    }
}