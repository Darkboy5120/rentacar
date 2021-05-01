package com.example.rentacar.models;

public abstract class ControlField {
    protected int et_id;
    protected int label_id;
    protected String value;
    protected Boolean is_done = false;
    protected final Boolean is_optional = false;

    public boolean isEmpty() {
        return this.value.length() > 0;
    }
    public String getValue() {
        return value;
    }
    public Boolean IsDone() {
        return is_done;
    }
}
