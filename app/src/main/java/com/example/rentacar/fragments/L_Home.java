package com.example.rentacar.fragments;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;

import com.example.rentacar.R;
import com.example.rentacar.activities.G_Login;
import com.example.rentacar.models.Global;

public class L_Home extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global;

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

        getActivity().setTitle(R.string.fragment_home_label);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        view.findViewById(R.id.layout_container).setOnClickListener(this);
        view.findViewById(R.id.signIn).setOnClickListener(this);

        View current = getActivity().getCurrentFocus();
        if (current != null) current.clearFocus();
        System.out.println("------------------------foofoofoofoo");
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(getContext(), getView());
        } else if (vId == R.id.signIn) {
            Intent i = new Intent(getActivity(), G_Login.class);
            startActivity(i);
        }
    }
}