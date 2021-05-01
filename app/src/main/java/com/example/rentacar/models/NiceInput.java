package com.example.rentacar.models;

import android.text.TextWatcher;
import android.view.View;
import android.widget.EditText;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class NiceInput extends ControlField {
    String regex;
    public NiceInput(int label_id, int et_id, String regex) {
        this.label_id = label_id;
        this.et_id = et_id;
        this.regex = regex;
    }

    public void setValue(String new_value) {
        this.value = new_value;
    }
    public boolean validate() {
        return this.value.matches(this.regex);
    }
}
