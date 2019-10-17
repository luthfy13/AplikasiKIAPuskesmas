package apps.lutfi.aplikasikesehatanibudananak;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.apache.http.util.EntityUtils;
import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Constructor;
import java.lang.reflect.Method;
import java.util.ArrayList;

public class SettingAkunActivity extends AppCompatActivity {

    EditText txtUser, txtPwd;
    private ProgressDialog progressDialog;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_setting_akun);

        txtUser = findViewById(R.id.txtUser);
        txtPwd = findViewById(R.id.txtPwd);
        txtUser.setText(MainActivity.username);

        ImageButton btnLoad = findViewById(R.id.btnLoad);
        ImageButton btnSimpan = findViewById(R.id.btnSimpan);
        ImageButton btnKembali = findViewById(R.id.btnKembali);
        btnKembali.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        //event Button
        btnLoad.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                txtUser.setText(MainActivity.username);
            }
        });

        btnSimpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                simpanData();
            }
        });
    }

    private void simpanData(){
        disableStrictMode();
        SimpanData mSimpanData = new SimpanData(SettingAkunActivity.this);
        mSimpanData.execute("");
    }

    private class SimpanData extends AsyncTask<String, Void, Boolean> {
        Context mContext = null;

        Exception exception = null;

        SimpanData(Context context){
            mContext = context;
        }

        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(SettingAkunActivity.this);
            progressDialog.setMessage("Menyimpan data...");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(false);
            progressDialog.show();
        }

        @Override
        protected Boolean doInBackground(String... arg0) {

            try{
                ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("txtUser", txtUser.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtPwd", txtPwd.getText().toString()));
                nameValuePairs.add(new BasicNameValuePair("txtCurrentUser", MainActivity.username));

                HttpParams httpParameters = new BasicHttpParams();

                HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
                HttpConnectionParams.setSoTimeout(httpParameters, 15000);

                HttpClient httpclient = new DefaultHttpClient(httpParameters);
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "simpanAkun.php");
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpclient.execute(httppost);
                HttpEntity entity = response.getEntity();

                String result = EntityUtils.toString(entity);

                System.out.println("Hasil response simpan: " + result);


            }catch (Exception e){
                Log.e("Error", "Error:", e);
                exception = e;
            }

            return true;
        }

        @Override
        protected void onPostExecute(Boolean valid){
            //StopWord = sw;
            //BtnProses.setEnabled(true);
            progressDialog.dismiss();
            MainActivity.username = txtUser.getText().toString();
            Toast.makeText(mContext, "Perubahan akun tersimpan...", Toast.LENGTH_LONG).show();
            finish();
        }

    }

    public static void disableStrictMode() {
        // StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
        // StrictMode.setThreadPolicy(policy);

        try {
            Class<?> strictModeClass = Class.forName("android.os.StrictMode", true, Thread.currentThread().getContextClassLoader());
            Class<?> threadPolicyClass = Class.forName("android.os.StrictMode$ThreadPolicy", true, Thread .currentThread().getContextClassLoader());
            Class<?> threadPolicyBuilderClass = Class.forName("android.os.StrictMode$ThreadPolicy$Builder", true, Thread.currentThread().getContextClassLoader());

            Method setThreadPolicyMethod = strictModeClass.getMethod("setThreadPolicy", threadPolicyClass);

            Method detectAllMethod = threadPolicyBuilderClass.getMethod("detectAll");
            Method penaltyMethod = threadPolicyBuilderClass.getMethod("penaltyLog");
            Method buildMethod = threadPolicyBuilderClass.getMethod("build");

            Constructor<?> threadPolicyBuilderConstructor = threadPolicyBuilderClass.getConstructor();
            Object threadPolicyBuilderObject = threadPolicyBuilderConstructor.newInstance();

            Object obj = detectAllMethod.invoke(threadPolicyBuilderObject);

            obj = penaltyMethod.invoke(obj);
            Object threadPolicyObject = buildMethod.invoke(obj);
            setThreadPolicyMethod.invoke(strictModeClass, threadPolicyObject);
        }
        catch (Exception ex) {
            Log.w("disableStrictMode", ex);
        }
    }

}
