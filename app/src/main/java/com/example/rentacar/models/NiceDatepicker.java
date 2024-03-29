package com.example.rentacar.models;

import android.annotation.SuppressLint;
import android.app.DatePickerDialog;
import android.text.InputType;
import android.util.Log;
import android.view.MotionEvent;
import android.view.View;
import android.widget.DatePicker;
import android.widget.EditText;

import androidx.core.content.ContextCompat;

import com.example.rentacar.R;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Locale;

public class NiceDatepicker extends ControlField {
    boolean second_touch = false;
    long milliseconds;

    @SuppressLint("ClickableViewAccessibility")
    public NiceDatepicker(int label_id, int input_id, int help_id, int log_id,
                          boolean is_optional, View view) {
        this.label_id = label_id;
        this.input_id = input_id;
        this.help_id = help_id;
        this.log_id = log_id;
        this.is_optional = is_optional;

        view.findViewById(input_id).setFocusable(View.NOT_FOCUSABLE);

        final Calendar myCalendar = Calendar.getInstance();
        this.milliseconds = myCalendar.getTimeInMillis();

        EditText et_view = view.findViewById(this.input_id);

        DatePickerDialog.OnDateSetListener date = new DatePickerDialog.OnDateSetListener() {
            @Override
            public void onDateSet(DatePicker v, int year, int monthOfYear, int dayOfMonth) {
                // TODO Auto-generated method stub
                myCalendar.set(Calendar.YEAR, year);
                myCalendar.set(Calendar.MONTH, monthOfYear);
                myCalendar.set(Calendar.DAY_OF_MONTH, dayOfMonth);
                updateValue(et_view, myCalendar);
                setLabelVisibility(view, View.VISIBLE);
                dismissLog(view);
            }
        };

        et_view.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (second_touch) {
                    new DatePickerDialog(view.getContext(), date, myCalendar
                            .get(Calendar.YEAR), myCalendar.get(Calendar.MONTH),
                            myCalendar.get(Calendar.DAY_OF_MONTH)).show();
                }
                second_touch = !second_touch;
                return false;
            }
        });
    }

    public void updateValue(EditText et, Calendar calendar)   {
        String myFormat = "dd/MM/yyyy";
        SimpleDateFormat sdf = new SimpleDateFormat(myFormat, Locale.US);

        et.setText(sdf.format(calendar.getTime()));
        this.milliseconds = calendar.getTimeInMillis();
    }

    public long getMilliseconds() {
        return this.milliseconds;
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

    @Override
    public String getValue(View v) {
        String raw_value = ((EditText) v.findViewById(this.input_id)).getText().toString();
        return raw_value.substring(6) + "-" + raw_value.substring(3, 5) + "-" + raw_value.substring(0, 2);
    }
}
