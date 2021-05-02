package com.example.rentacar.fragments;

import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.LinearLayout;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.navigation.fragment.NavHostFragment;

import com.example.rentacar.R;
import com.example.rentacar.activities.L_Register;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceDatepicker;
import com.example.rentacar.models.NiceInput;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Calendar;
import java.util.Date;

public class L_Register_Step1 extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;
    NiceInput ni_firstname, ni_lastname, ni_password;
    NiceDatepicker ndp_birthdate;

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

        view.findViewById(R.id.signUp).setOnClickListener(this);

        ni_firstname = new NiceInput("text", R.id.label_et_firstname, R.id.et_firstname,
                R.id.help_et_firstname,  R.id.log_et_firstname, "^[A-Za-z]+", 5,
                25, false, requireView());
        ni_lastname = new NiceInput("text", R.id.label_et_lastname, R.id.et_lastname,
                R.id.help_et_lastname,  R.id.log_et_lastname, "^[A-Za-z]+", 5,
                25, false, requireView());
        ndp_birthdate = new NiceDatepicker(R.id.label_et_birthdate, R.id.et_birthdate,
                R.id.help_et_birthdate, R.id.log_et_birthdate, false, requireView());
        ni_password = new NiceInput("password", R.id.label_et_password, R.id.et_password,
                R.id.help_et_password,  R.id.log_et_password, "^[A-Za-z]+", 5,
                25, false, requireView());
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

        NiceInput[] ni_arr = {ni_firstname, ni_lastname, ni_password};
        for (NiceInput nice_input : ni_arr) {
            if (!nice_input.validate(requireView())) {
                result = false;
            }
        }
        if (!ndp_birthdate.validate(requireView())) {
            result = false;
        }
        try {
            Calendar calendar = Calendar.getInstance();
            int now = calendar.get(Calendar.YEAR);
            long birthdate = new SimpleDateFormat("dd/MM/yyyy").parse(ndp_birthdate.getValue(requireView())).getTime();
            calendar.setTimeInMillis(birthdate);
            int b_years = now - calendar.get(Calendar.YEAR);

            if (b_years < 18) {
                ndp_birthdate.printLog(requireView(), getResources().getString(R.string.error_et_age_restriction));
            }
        } catch (Exception e) {
        }

        return result;
    }

    public void signUp() {
        if (!signUp_validate()) return;
        NavHostFragment.findNavController(L_Register_Step1.this)
                .navigate(R.id.action_FragmentRegisterStep1_to_FragmentRegisterStep2);
    }
}