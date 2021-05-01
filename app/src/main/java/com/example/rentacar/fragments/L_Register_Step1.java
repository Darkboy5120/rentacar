package com.example.rentacar.fragments;

import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.LinearLayout;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.navigation.fragment.NavHostFragment;

import com.example.rentacar.R;
import com.example.rentacar.activities.L_Register;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceInput;

public class L_Register_Step1 extends Fragment implements View.OnClickListener, TextWatcher {
    LinearLayout ll_spn_global;
    NiceInput ni_firstname;

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

        ni_firstname = new NiceInput(R.id.label_et_firstname, R.id.et_firstname, "^[A-Za-z]+");
        ((EditText) view.findViewById(R.id.et_firstname)).addTextChangedListener(this);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.signUp) {
            signUp();
        } else if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        }
    }

    public void signUp() {
        NavHostFragment.findNavController(L_Register_Step1.this)
                .navigate(R.id.action_FragmentRegisterStep1_to_FragmentRegisterStep2);
    }

    @Override
    public void beforeTextChanged(CharSequence s, int start, int count, int after) {
    }

    @Override
    public void onTextChanged(CharSequence s, int start, int before, int count) {
        int vId = getActivity().getCurrentFocus().getId();
        if (vId == R.id.et_firstname) {
            ni_firstname.setValue(s.toString());
            ni_firstname.validate();
        }
    }

    @Override
    public void afterTextChanged(Editable s) {
    }
}