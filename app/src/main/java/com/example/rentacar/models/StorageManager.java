package com.example.rentacar.models;

import android.content.Context;
import android.content.SharedPreferences;

public class StorageManager {
    private final static String STORAGE_NAME = "Preferences";
    private final static String DEFAULT_VALUE = "";
    private final Context context;

    public StorageManager(Context context) {
        this.context = context;
    }

    public String getString(String name) {
        SharedPreferences settings = context.getSharedPreferences(STORAGE_NAME, Context.MODE_PRIVATE);
        return settings.getString(name, DEFAULT_VALUE);
    }

    public void setString(String name, String value) {
        SharedPreferences settings = this.context.getSharedPreferences(STORAGE_NAME, Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = settings.edit();
        editor.putString(name, value);
        editor.apply();
    }

    public void clearString(String name) {
        this.setString(name, DEFAULT_VALUE);
    }
}
