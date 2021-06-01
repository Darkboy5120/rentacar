package com.example.rentacar.models;

import android.annotation.SuppressLint;
import android.app.DatePickerDialog;
import android.app.TimePickerDialog;
import android.text.InputType;
import android.view.MotionEvent;
import android.view.View;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.TimePicker;

import androidx.core.content.ContextCompat;

import com.example.rentacar.R;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Locale;

public class NiceTimepicker extends ControlField {
    boolean second_touch = false;
    long milliseconds;

    @SuppressLint("ClickableViewAccessibility")
    public NiceTimepicker(int label_id, int input_id, int help_id, int log_id,
                          boolean is_optional, View view) {
        this.label_id = label_id;
        this.input_id = input_id;
        this.help_id = help_id;
        this.log_id = log_id;
        this.is_optional = is_optional;

        final Calendar myCalendar = Calendar.getInstance();
        this.milliseconds = myCalendar.getTimeInMillis();

        EditText et_view = view.findViewById(this.input_id);

        TimePickerDialog.OnTimeSetListener time_listener = new TimePickerDialog.OnTimeSetListener() {
            @Override
            public void onTimeSet(TimePicker v, int hourOfDay, int minute) {
                // TODO Auto-generated method stub
                updateValue(et_view, hourOfDay, minute, myCalendar);
                setLabelVisibility(view, View.VISIBLE);
                dismissLog(view);
            }
        };

        et_view.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View v, MotionEvent event) {
                if (second_touch) {
                    new TimePickerDialog(view.getContext(), time_listener,
                            myCalendar.get(Calendar.HOUR_OF_DAY),
                            myCalendar.get(Calendar.MINUTE), true).show();
                }
                second_touch = !second_touch;
                return false;
            }
        });
    }

    public void updateValue(EditText et, int hourofday, int minute, Calendar calendar)   {
        String time = hourofday + ":" + minute;
        et.setText(time);
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
}
