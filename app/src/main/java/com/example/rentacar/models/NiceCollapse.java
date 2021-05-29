package com.example.rentacar.models;

import android.annotation.SuppressLint;
import android.text.InputType;
import android.view.MotionEvent;
import android.view.View;
import android.widget.EditText;

import androidx.core.content.ContextCompat;

import com.example.rentacar.R;

public class NiceCollapse {
    int trigger_id, content_id;
    boolean status = false;

    public NiceCollapse(int trigger_id, int content_id, View view) {
        this.trigger_id = trigger_id;
        this.content_id = content_id;

        this.update(view);

        View trigger_view = this.getTriggetView(view);
        trigger_view.setOnClickListener(v -> toggleStatus(view));
    }

    public void toggleStatus(View view) {
        this.status = !this.status;
        this.update(view);
    }

    public void setStatus(View view, Boolean new_status) {
        this.status = new_status;
        this.update(view);
    }

    private void update(View view) {
        View content_view = this.getContentView(view);
        if (this.status) {
            content_view.setVisibility(View.VISIBLE);
        } else {
            content_view.setVisibility(View.GONE);
        }
    }

    private View getTriggetView(View view) {
        return view.findViewById(this.trigger_id);
    }

    private View getContentView(View view) {
        return view.findViewById(this.content_id);
    }
}