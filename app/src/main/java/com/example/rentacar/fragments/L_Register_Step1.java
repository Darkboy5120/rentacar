package com.example.rentacar.fragments;

import android.content.Context;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.navigation.fragment.NavHostFragment;

import com.android.volley.DefaultRetryPolicy;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.activities.L_Register;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceDatepicker;
import com.example.rentacar.models.NiceInput;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.time.LocalDate;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import static android.provider.ContactsContract.CommonDataKinds.Website.URL;

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
                R.id.help_et_firstname,  R.id.log_et_firstname, "^[A-Za-z-ZÀ-ÿ-\u00f1\u00d1\\s']+", 1,
                50, false, requireView());
        ni_lastname = new NiceInput("text", R.id.label_et_lastname, R.id.et_lastname,
                R.id.help_et_lastname,  R.id.log_et_lastname, "^[A-Za-z-ZÀ-ÿ-\u00f1\u00d1']+", 1,
                50, false, requireView());
        ndp_birthdate = new NiceDatepicker(R.id.label_et_birthdate, R.id.et_birthdate,
                R.id.help_et_birthdate, R.id.log_et_birthdate, false, requireView());
        ni_password = new NiceInput("password", R.id.label_et_password, R.id.et_password,
                R.id.help_et_password,  R.id.log_et_password, "^[A-Za-z0-9À-ÿ-\u00f1\u00d1']+", 5,
                50, false, requireView());
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
                result = false;
            }
        } catch (Exception e) {
        }

        return result;
    }

    public Bundle get_form_values() {
        Bundle bundle = new Bundle();
        bundle.putString("firstname", ni_firstname.getValue(requireView()));
        bundle.putString("lastname", ni_lastname.getValue(requireView()));
        bundle.putString("birthdate", ndp_birthdate.getValue(requireView()));
        bundle.putString("password", ni_password.getValue(requireView()));

        return bundle;
    }

    public void next_fragment() {
        L_Register_Step2 fragment = new L_Register_Step2();
        fragment.setArguments(get_form_values());

        getActivity().getSupportFragmentManager().beginTransaction()
                .replace(((ViewGroup)getView().getParent()).getId(), fragment)
                .addToBackStack(null)
                .commit();
    }

    public void signUp() {
        Global.hideKeyboardFrom(requireContext(), requireView());
        if (!signUp_validate()) return;
        next_fragment();
    }
}