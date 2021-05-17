package com.example.rentacar.fragments;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
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
import com.example.rentacar.activities.G_Login;
import com.example.rentacar.activities.L_Cars;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceDatepicker;
import com.example.rentacar.models.NiceInput;
import com.example.rentacar.models.NiceTimepicker;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.net.MalformedURLException;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

public class L_Home extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;
    NiceInput ni_minprice, ni_maxprice;
    NiceDatepicker ndp_startdate, ndp_enddate;
    NiceTimepicker ntp_starttime, ntp_endtime;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_home, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_l_home_title);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        view.findViewById(R.id.layout_container).setOnClickListener(this);
        view.findViewById(R.id.search_form_submit).setOnClickListener(this);
        ni_minprice = new NiceInput("text", R.id.label_et_minprice, R.id.et_minprice,
                R.id.help_et_minprice,  R.id.log_et_minprice, "^[0-9]+", 3,
                5, true, requireView());
        ni_maxprice = new NiceInput("text", R.id.label_et_maxprice, R.id.et_maxprice,
                R.id.help_et_maxprice,  R.id.log_et_maxprice, "^[0-9]+", 3,
                5, true, requireView());
        ndp_startdate = new NiceDatepicker(R.id.label_dp_startdate, R.id.dp_startdate,
                R.id.help_dp_startdate, R.id.log_dp_startdate, false, requireView());
        ndp_enddate = new NiceDatepicker(R.id.label_dp_enddate, R.id.dp_enddate,
                R.id.help_dp_enddate, R.id.log_dp_enddate, false, requireView());
        ntp_starttime = new NiceTimepicker(R.id.label_tp_starttime, R.id.tp_starttime,
                R.id.help_tp_starttime, R.id.log_tp_starttime, false, requireView());
        ntp_endtime = new NiceTimepicker(R.id.label_tp_endtime, R.id.tp_endtime,
                R.id.help_tp_endtime, R.id.log_tp_endtime, false, requireView());
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        } else if (vId == R.id.search_form_submit) {
            make_search();
        }
    }

    public boolean make_search_validate() {
        boolean result = true;

        NiceInput[] ni_arr = {ni_minprice, ni_maxprice};
        for (NiceInput nice_input : ni_arr) {
            if (!nice_input.validate(requireView())) {
                result = false;
            }
        }

        NiceDatepicker[] ndp_arr = {ndp_startdate, ndp_enddate};
        for (NiceDatepicker nice_date_picker : ndp_arr) {
            if (!nice_date_picker.validate(requireView())) {
                result = false;
            }
        }

        NiceTimepicker[] ntp_arr = {ntp_starttime, ntp_endtime};
        for (NiceTimepicker nice_time_picker : ntp_arr) {
            if (!nice_time_picker.validate(requireView())) {
                result = false;
            }
        }

        return result;
    }

    public void make_search() {
        Global.hideKeyboardFrom(requireContext(), requireView());
        if (!make_search_validate()) return;
        next_activity();
    }

    public Bundle get_form_values() {
        Bundle bundle = new Bundle();
        //bundle.putString("firstname", ni_firstname.getValue(requireView()));

        return bundle;
    }

    public void next_activity() {
        Intent i = new Intent(requireContext(), L_Cars.class);
        //i.putExtra();
        startActivity(i);
    }
}