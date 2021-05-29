package com.example.rentacar.fragments;

import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceCollapse;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.util.HashMap;
import java.util.Map;

public class L_Details extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;
    NiceCollapse nc_car_spaces;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_details, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_l_cars_title);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        view.findViewById(R.id.layout_container).setOnClickListener(this);

        assert getArguments() != null;
        Global.setImage(getArguments().getString("imagen_ruta"),
                ((ImageView) requireView().findViewById(R.id.car_image)));
        ((TextView) requireView().findViewById(R.id.car_name))
                .setText(getArguments().getString("nombre"));
        ((TextView) requireView().findViewById(R.id.car_price))
                .setText(getArguments().getString("precio"));
        ((TextView) requireView().findViewById(R.id.car_doors))
                .setText(getArguments().getString("puertas"));
        ((TextView) requireView().findViewById(R.id.car_chairs))
                .setText(getArguments().getString("asientos"));
        nc_car_spaces = new NiceCollapse(R.id.ll_c_spaces_trigger, R.id.ll_c_spaces_content, requireView());
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        }
    }
}