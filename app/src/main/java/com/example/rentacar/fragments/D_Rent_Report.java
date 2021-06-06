package com.example.rentacar.fragments;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.LinearLayout;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.example.rentacar.R;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceSpinner;
import com.example.rentacar.models.StorageManager;

public class D_Rent_Report extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_d_rent_report, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_d_rent_report_title);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        view.findViewById(R.id.layout_container).setOnClickListener(this);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        }
    }
}
