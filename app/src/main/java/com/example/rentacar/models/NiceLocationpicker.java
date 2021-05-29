package com.example.rentacar.models;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.DatePickerDialog;
import android.content.Intent;
import android.text.InputType;
import android.view.MotionEvent;
import android.view.View;
import android.widget.DatePicker;
import android.widget.EditText;

import androidx.core.content.ContextCompat;
import androidx.fragment.app.Fragment;

import com.example.rentacar.R;
import com.example.rentacar.activities.GetLocation;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Locale;

public class NiceLocationpicker extends ControlField {
    boolean second_touch = false;
    private static int REQUEST_COUNT = 0;
    public int REQUEST_CODE;
    public int REQUEST_OK = 0;
    private String latitude;
    private String longitude;

    @SuppressLint("ClickableViewAccessibility")
    public NiceLocationpicker(int label_id, int input_id, int help_id, int log_id,
                              boolean is_optional, View view, Activity activity, Fragment fragment) {
        this.label_id = label_id;
        this.input_id = input_id;
        this.help_id = help_id;
        this.log_id = log_id;
        this.is_optional = is_optional;
        this.REQUEST_CODE = REQUEST_COUNT;
        REQUEST_COUNT++;

        view.findViewById(input_id).setFocusable(View.NOT_FOCUSABLE);
        EditText et_view = view.findViewById(this.input_id);

        et_view.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (second_touch) {
                    Intent i = new Intent(activity, GetLocation.class);
                    fragment.startActivityForResult(i, REQUEST_CODE);
                }
                second_touch = !second_touch;
                return false;
            }
        });
    }

    @Override
    public boolean validate(View v) {
        String value = ((EditText) v.findViewById(this.input_id)).getText().toString();
        if (value.length() == 0 && !this.is_optional) {
            this.printLog(v, v.getResources().getString(R.string.error_et_empty));
            return false;
        }

        this.dismissLog(v);
        return true;
    }

    public void listenResult(int request_code, int result_code, Intent data, View v) {
        if (request_code == this.REQUEST_CODE && data != null) {
            if (result_code == this.REQUEST_OK) {
                this.latitude = (String) data.getExtras().getString("latitude");
                this.longitude = (String) data.getExtras().getString("longitude");
                updateValue(v);
            }
        }
    }

    public void updateValue(View v) {
        String value = this.latitude + ", " + this.longitude;
        ((EditText) v.findViewById(this.input_id)).setText(value);
    }

    public String getLatitude() {
        return this.latitude;
    }

    public String getLongitude() {
        return this.longitude;
    }
}
