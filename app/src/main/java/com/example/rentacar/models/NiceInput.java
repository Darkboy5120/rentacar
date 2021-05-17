package com.example.rentacar.models;

import android.annotation.SuppressLint;
import android.text.InputType;
import android.text.TextWatcher;
import android.view.MotionEvent;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

import androidx.core.content.ContextCompat;

import com.example.rentacar.R;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class NiceInput extends ControlField {
    String regex;
    int min_length;
    int max_length;
    boolean password_mask = false;
    int default_password_mask;


    @SuppressLint("ClickableViewAccessibility")
    public NiceInput(String et_type, int label_id, int input_id, int help_id, int log_id, String regex,
                     int min_length, int max_length, boolean is_optional,
                     View view) {
        this.label_id = label_id;
        this.input_id = input_id;
        this.help_id = help_id;
        this.log_id = log_id;
        this.regex = regex;
        this.min_length = min_length;
        this.max_length = max_length;
        this.is_optional = is_optional;

        EditText et_view = view.findViewById(this.input_id);
        this.default_password_mask = et_view.getInputType();

        et_view.setOnFocusChangeListener(new View.OnFocusChangeListener() {
            @Override
            public void onFocusChange(View v, boolean hasFocus) {
                onFocusEvent(view, hasFocus);
            }
        });

        if (et_type.equals("password")) {
            et_view.setOnTouchListener(new View.OnTouchListener() {
                @Override
                public boolean onTouch(View v, MotionEvent event) {
                    final int DRAWABLE_RIGHT = 2;

                    if(event.getAction() == MotionEvent.ACTION_UP) {
                        if(event.getRawX() >= (((EditText) view.findViewById(input_id)).getRight() - ((EditText) view
                                .findViewById(input_id)).getCompoundDrawables()[DRAWABLE_RIGHT].getBounds().width())) {
                            // your action here
                            togglePasswordMask(view);

                            return true;
                        }
                    }
                    return false;
                }
            });
        }
    }

    public void togglePasswordMask(View v) {
        this.password_mask = !this.password_mask;

        EditText et_view = v.findViewById(this.input_id);
        int new_password_mask;
        int new_drawable;

        if (this.password_mask) {
            new_password_mask = InputType.TYPE_TEXT_VARIATION_VISIBLE_PASSWORD;
            new_drawable = R.drawable.ic_visibility_off;
        } else {
            new_password_mask = this.default_password_mask;
            new_drawable = R.drawable.ic_visibility;
        }

        et_view.setInputType(new_password_mask);
        et_view.setCompoundDrawablesWithIntrinsicBounds(null, null, ContextCompat
                .getDrawable(v.getContext(), new_drawable), null);
    }

    @Override
    public boolean validate(View v) {
        String value = ((EditText) v.findViewById(this.input_id)).getText().toString();
        if (value.length() == 0 && this.is_optional) {
            return true;
        } if (value.length() == 0) {
            this.printLog(v, v.getResources().getString(R.string.error_et_empty));
            return false;
        } else if (value.length() < this.min_length) {
            this.printLog(v, v.getResources().getString(R.string.error_et_minlength));
            return false;
        } else if (value.length() > this.max_length) {
            this.printLog(v, v.getResources().getString(R.string.error_et_maxlength));
            return false;
        } else if (!value.matches(this.regex)) {
            this.printLog(v, v.getResources().getString(R.string.error_et_invalid));
            return false;
        }

        this.dismissLog(v);
        return true;
    }
    public void onFocusEvent(View v, boolean has_focus) {
        String value = ((EditText) v.findViewById(this.input_id)).getText().toString();
        this.setLabelVisibility(v, (has_focus || value.length() > 0) ? View.VISIBLE : View.INVISIBLE);
        if (!has_focus && !this.isEmpty(v)) {
            this.validate(v);
        } else if (!has_focus && this.isEmpty(v)) {
            this.dismissLog(v);
        }
    }

    public boolean isEmpty(View v) {
        return ((EditText) v.findViewById(this.input_id)).getText().length() <= 0;
    }
}
