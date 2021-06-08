package com.example.rentacar.fragments;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.navigation.ui.NavigationUI;

import com.android.volley.NetworkResponse;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.example.rentacar.R;
import com.example.rentacar.activities.L_Home;
import com.example.rentacar.models.Global;
import com.example.rentacar.models.NiceFileInput;
import com.example.rentacar.models.NiceInput;
import com.example.rentacar.models.NiceSpinner;
import com.example.rentacar.models.StorageManager;
import com.example.rentacar.models.VolleyMultipartRequest;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.HashMap;
import java.util.Map;

public class D_Rent_Report extends Fragment implements View.OnClickListener,
        AdapterView.OnItemSelectedListener {
    LinearLayout ll_spn_global, ll_report_items;
    NiceInput ni_report_description;
    NiceFileInput nfi_item_image;
    NiceSpinner ns_report_items;
    AlertDialog.Builder report_dialog;
    View dialog_form_view = null;
    ArrayList<String> report_items_data = new ArrayList<>();
    ArrayList<Bitmap> report_items_images = new ArrayList<>();
    String items_response;

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
        ll_report_items = view.findViewById(R.id.layout_report_items);
        view.findViewById(R.id.add_item).setOnClickListener(this);
        view.findViewById(R.id.layout_container).setOnClickListener(this);
        view.findViewById(R.id.submit).setOnClickListener(this);

        ni_report_description = new NiceInput("text", R.id.label_et_report_description, R.id.et_report_description,
                R.id.help_et_report_description,  R.id.log_et_report_description, "^[A-Za-z-ZÀ-ÿ-\u00f1\u00d1\\s']+", 15,
                255, false, requireView());

        build_report_dialog();
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        nfi_item_image.listenResult(requireActivity(), dialog_form_view, requestCode, resultCode, data);
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        } else if (vId == R.id.add_item) {
            build_report_dialog();
            report_dialog.show();
        } else if (vId == R.id.submit) {
            submit();
        }
    }

    @Override
    public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
        if (parent.getId() == R.id.et_report_items) {
            ns_report_items.updateIndex(position);
        }
    }

    @Override
    public void onNothingSelected(AdapterView<?> parent) {

    }

    public boolean submit_validate() {
        boolean result = true;

        NiceInput[] ni_arr = {ni_report_description};
        for (NiceInput nice_input : ni_arr) {
            if (!nice_input.validate(requireView())) {
                result = false;
            }
        }

        NiceFileInput[] nfi_arr = {nfi_item_image};
        for (NiceFileInput nice_file_input : nfi_arr) {
            if (!nice_file_input.validate(requireView())) {
                result = false;
            }
        }

        return result;
    }

    public void submit() {
        Global.hideKeyboardFrom(requireContext(), requireView());
        if (!submit_validate()) return;
        upload_report();
    }

    public void upload_report() {
        ll_spn_global.setVisibility(View.VISIBLE);

        VolleyMultipartRequest volleyMultipartRequest = new VolleyMultipartRequest(Request.Method.POST, Global.apis_path,
                new Response.Listener<NetworkResponse>() {
                    @Override
                    public void onResponse(NetworkResponse response) {
                        try {
                            ll_spn_global.setVisibility(View.GONE);
                            JSONObject json = new JSONObject(new String(response.data));
                            Log.d("foo", json.toString());
                            String code = json.getString("code");
                            if (code.equals("0")) {
                                //back to rents fragment
                                D_Driver_Delivery fragment = new D_Driver_Delivery();

                                getActivity().getSupportFragmentManager().beginTransaction()
                                        .replace(((ViewGroup)getView().getParent()).getId(), fragment)
                                        .addToBackStack(null)
                                        .commit();
                            } else {
                                Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request));
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request));
                    }
                }) {

            @Override
            public Map<String, String> getParams()  {
                HashMap<String, String> headers = new HashMap<String, String>();
                headers.put("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
                headers.put("api", "upload_penalties");
                headers.put("fk_renta", getArguments().getString("pk_renta"));
                headers.put("todo_bien", "1");
                headers.put("descripcion", ni_report_description.getValue(requireView()));
                return headers;
            }

            @Override
            protected Map<String, DataPart> getByteData() {
                Map<String, VolleyMultipartRequest.DataPart> params = new HashMap<>();

                //params.put("image" + 0, new DataPart("image" + 0, VolleyMultipartRequest.getFileDataFromDrawable(report_items_images.get(0))));
                for (int i = 0; i < report_items_images.size(); i++) {
                    params.put("image" + i, new DataPart(report_items_data.get(i), VolleyMultipartRequest.getFileDataFromDrawable(report_items_images.get(i))));
                }
                return params;
            }
        };
        Volley.newRequestQueue(requireContext()).add(volleyMultipartRequest);
    }

    public boolean add_new_report_item_validate() {
        boolean result = true;
        if (!nfi_item_image.validate(dialog_form_view)
            || !ns_report_items.validate(dialog_form_view)) {
            result = false;
        }

        return result;
    }

    public void add_new_report_item() {
        if (!add_new_report_item_validate())
            return;
        //add new one
        try {
            if (report_items_data.size() == 0) {
                ll_report_items.findViewById(R.id.report_items_empty).setVisibility(View.GONE);
            }

            //get values
            int current_index = ns_report_items.getIndex();
            JSONObject json_row = new JSONObject(ns_report_items.getTrauctorItem(current_index));
            String pk_penalizacion = json_row.getString("pk_penalizacion");
            String nombre = json_row.getString("nombre");
            String precio = json_row.getString("precio");
            String file_type = nfi_item_image.getFileType();
            Bitmap file = nfi_item_image.getFile();

            //add card view to layout
            View card_report_item = LayoutInflater.from(requireContext()).inflate(
                    R.layout.component_report_item_card, ll_report_items, false);
            ll_report_items.addView(card_report_item);
            ((TextView) card_report_item.findViewById(R.id.item_name)).setText(nombre);
            ((TextView) card_report_item.findViewById(R.id.item_price)).setText(
                    new String(
                            getResources().getString(R.string.label_tv_price_simbol) +
                                    precio + " " +
                                    getResources().getString(R.string.label_tv_price_extra_simple)
                    )
            );

            //add data to json arr
            report_items_data.add(pk_penalizacion);
            //add image to images arr
            report_items_images.add(file);
            Log.d("json", report_items_data.toString());
            Log.d("images", report_items_images.size() + "");
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }

    public void build_report_dialog() {
        boolean first_time = (dialog_form_view == null) ? true: false;
        dialog_form_view = getLayoutInflater().inflate(R.layout.component_report_form, null);
        report_dialog = new AlertDialog.Builder(getContext())
                .setView(dialog_form_view)
                .setMessage(getResources().getString(R.string.dialog_report_items))
                .setPositiveButton(R.string.save_report, (dialog, id) -> {
                    add_new_report_item();
                })
                .setNegativeButton(R.string.places_cancel, null);

        ns_report_items = new NiceSpinner(R.id.label_et_report_items, R.id.et_report_items, R.id.help_et_report_items,
                R.id.log_et_report_items, false, dialog_form_view, this);
        if (first_time) get_report_items();
        else fill_report_items_spinner(items_response);
        nfi_item_image = new NiceFileInput(R.id.label_et_item_image, R.id.status_et_item_image, R.id.btn_item_image,
                R.id.help_et_item_image, R.id.log_et_item_image, dialog_form_view, requireActivity(),
                D_Rent_Report.this);
    }

    public void get_report_items() {
        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Global.apis_path,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        items_response = response;
                        fill_report_items_spinner(response);
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Global.printMessage(requireView(), getResources().getString(R.string.error_generic_request));
                    }
                }) {
            @Override
            public Map<String, String> getParams()  {
                HashMap<String, String> headers = new HashMap<String, String>();
                headers.put("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
                headers.put("api", "get_penalties");
                return headers;
            }
        };
        queue.add(stringRequest);
    }

    public void fill_report_items_spinner(String response) {
        try {
            JSONObject json = new JSONObject(response);
            JSONArray data = json.getJSONArray("data");
            String code = json.getString("code");
            if (code.equals("0")) {
                ArrayList<String> penalties = new ArrayList<>();
                for (int i = 0; i < data.length(); i++) {
                    JSONObject row = new JSONObject(data.getString(i));
                    penalties.add(row.getString("nombre"));
                    ns_report_items.traductorPush(row.toString());
                }

                ns_report_items.setAdapter(dialog_form_view, penalties.toArray(new String[0]));
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
    }
}
