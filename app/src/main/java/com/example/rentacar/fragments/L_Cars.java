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
import com.example.rentacar.activities.G_Login;
import com.example.rentacar.models.Global;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.io.InputStream;
import java.net.URL;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class L_Cars extends Fragment implements View.OnClickListener {
    LinearLayout ll_spn_global, ll_cars;

    @Override
    public View onCreateView(
            LayoutInflater inflater, ViewGroup container,
            Bundle savedInstanceState
    ) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_l_cars, container, false);
    }

    public void onViewCreated(@NonNull View view, Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

        requireActivity().setTitle(R.string.fragment_l_cars_title);
        ll_spn_global = view.findViewById(R.id.layout_spn_global);
        ll_cars = view.findViewById(R.id.layout_cars);
        view.findViewById(R.id.layout_container).setOnClickListener(this);

        get_search_data();
    }

    @Override
    public void onClick(View v) {
        int vId = v.getId();
        if (vId == R.id.layout_container) {
            Global.hideKeyboardFrom(requireContext(), requireView());
        }
    }

    Bitmap get_bitmap_from_url(String imageUrl) {
        try {
            return BitmapFactory.decodeStream((InputStream) new URL(imageUrl).getContent());
        } catch (IOException e) {
            e.printStackTrace();
        }
        return null;
    }

    void set_image(String url, ImageView view) {
        new Thread(() -> {
            final Bitmap bitmap =
                    get_bitmap_from_url(url);
            view.post(() -> view.setImageBitmap(bitmap));
        }).start();
    }

    public void get_search_data() {
        Intent i = requireActivity().getIntent();
        make_search_in_server(
                i.getStringExtra("minprice"),
                i.getStringExtra("maxprice"),
                i.getStringExtra("startlocation_latitude"),
                i.getStringExtra("startlocation_longitude"),
                i.getStringExtra("startdate"),
                i.getStringExtra("starttime"),
                i.getStringExtra("endlocation_latitude"),
                i.getStringExtra("endlocation_longitude"),
                i.getStringExtra("enddate"),
                i.getStringExtra("endtime")
        );
    }

    public void make_search_in_server(String minprice, String maxprice, String startlocation_latitude,
                                      String startlocation_longitude, String startdate, String starttime,
                                      String endlocation_latitude, String endlocation_longitude,
                                      String enddate, String endtime) {
        ll_spn_global.setVisibility(View.VISIBLE);

        RequestQueue queue = Volley.newRequestQueue(requireContext());
        StringRequest stringRequest = new StringRequest(Request.Method.POST, Global.apis_path,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            ll_spn_global.setVisibility(View.GONE);
                            JSONObject json = new JSONObject(response);
                            String code = json.getString("code");
                            if (code.equals("0")) {
                                JSONObject data = json.getJSONObject("data");
                                JSONArray cars = data.getJSONArray("cars");
                                View car_card = null;
                                JSONObject row;
                                for (int i = 0; i < cars.length(); i++) {
                                    row = cars.getJSONObject(i);
                                    String image_path = Global.domain_name + row.getString("imagen_ruta").substring(5);
                                    car_card = LayoutInflater.from(requireContext()).inflate(
                                            R.layout.component_cardcar, ll_cars, false);
                                    ImageView car_image = car_card.findViewById(R.id.car_image);
                                    set_image(image_path, car_image);
                                    car_image.setId(i);

                                    ll_cars.addView(car_card);
                                }
                                //String user_id = data.getString("pk_usuario");

                                ArrayList<View> car_card_childrens = Global.getAllChildren(car_card);
                                //set view values
                                //TextView bNameView = Global.searchViewByText(appointments_cards, "beneficiary_name");
                                //bNameView.setText(b_fullname);
                            } else if (code.equals("-3")) {
                                requireView().findViewById(R.id.cars_empty).setVisibility(View.VISIBLE);
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
                headers.put("api", "get_filtered_cars");
                headers.put("securitykey", Global.security_key);
                headers.put("offset", "0");
                headers.put("limit", "15");
                headers.put("minprice", minprice);
                headers.put("maxprice", maxprice);
                headers.put("startlocation_latitude", startlocation_latitude);
                headers.put("startlocation_longitude", startlocation_longitude);
                headers.put("startdate", startdate);
                headers.put("starttime", starttime);
                headers.put("endlocation_latitude", endlocation_latitude);
                headers.put("endlocation_longitude", endlocation_longitude);
                headers.put("enddate", enddate);
                headers.put("endtime", endtime);
                return headers;
            }
        };
        queue.add(stringRequest);
    }
}
