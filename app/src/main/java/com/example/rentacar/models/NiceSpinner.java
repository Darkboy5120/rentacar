package com.example.rentacar.models;

import android.annotation.SuppressLint;
import android.text.InputType;
import android.view.MotionEvent;
import android.view.View;
import android.widget.Adapter;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.SearchView;
import android.widget.Spinner;
import android.widget.SpinnerAdapter;

import androidx.core.content.ContextCompat;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class NiceSpinner extends ControlField {
    ArrayAdapter<String> adapter;
    ArrayList<String> traductor = new ArrayList<>();
    int index;

    public NiceSpinner(int label_id, int input_id, int help_id, int log_id, boolean is_optional,
                       View view, AdapterView.OnItemSelectedListener isl) {
        this.label_id = label_id;
        this.input_id = input_id;
        this.help_id = help_id;
        this.log_id = log_id;
        this.is_optional = is_optional;

        Spinner spn_state = (Spinner) view.findViewById(this.input_id);
        spn_state.setOnItemSelectedListener(isl);
    }

    @Override
    public boolean validate(View v) {
        return true;
    }

    public void setAdapter(View v, String[] data) {
        this.adapter =
                new ArrayAdapter<String>(v.getContext(), android.R.layout.simple_list_item_1, data);
        ((Spinner) v.findViewById(this.input_id)).setAdapter(adapter);
    }

    public void traductorPush(String s) {
        this.traductor.add(s);
    }

    public String getTrauctorItem(int index) {
        return this.traductor.get(index);
    }

    public void updateIndex(int new_index) {
        this.index = new_index;
    }

    public int getIndex() {
        return this.index;
    }
}
