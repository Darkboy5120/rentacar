package com.example.rentacar.models;

import android.view.View;
import android.widget.EditText;
import android.widget.TextView;

public abstract class ControlField {
    protected int input_id;
    protected int label_id;
    protected int help_id;
    protected int log_id;
    protected Boolean is_optional = false;
    protected abstract boolean validate(View v);
    public void setLabelVisibility(View v, int value) {
        v.findViewById(this.label_id).setVisibility(value);
    }
    public void setHelpVisibility(View v, int value) {
        v.findViewById(this.help_id).setVisibility(value);
    }
    public void setLogVisibility(View v, int value) {
        v.findViewById(this.log_id).setVisibility(value);
    }
    public void printLog(View v, String s) {
        ((TextView) v.findViewById(this.log_id)).setText(s);
        this.setHelpVisibility(v, View.GONE);
        this.setLogVisibility(v, View.VISIBLE);
    }
    public void dismissLog(View v) {
        this.setLogVisibility(v, View.GONE);
        this.setHelpVisibility(v, View.VISIBLE);
    }
    public String getValue(View v) {
        return ((EditText) v.findViewById(this.input_id)).getText().toString();
    }
}
