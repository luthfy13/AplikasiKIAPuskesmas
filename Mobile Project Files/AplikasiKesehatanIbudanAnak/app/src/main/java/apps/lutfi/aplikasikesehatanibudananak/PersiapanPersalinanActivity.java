package apps.lutfi.aplikasikesehatanibudananak;

import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
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
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.lang.reflect.Constructor;
import java.lang.reflect.Method;
import java.util.ArrayList;

public class PersiapanPersalinanActivity extends AppCompatActivity {

    private EditText txtNoReg, txtNama, txtAlamat, txtPerkiraan, txtKB, txtDana, txtPetugas1,
            txtPetugas2, txtAmbulance1, txtAmbulance2, txtAmbulance3, txtPendonor1, txtPendonor2,
            txtPendonor3;
    private ProgressDialog progressDialog;
    private JSONObject hasilJsonObject = null;
    private JSONArray jsonArray;
    String[] ambulanceNama, ambulanceTelp, pendonorNama, pendonorTelp;
    private int i;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_persiapan_persalinan);

        txtNoReg = findViewById(R.id.txtNoReg);
        txtNama = findViewById(R.id.txtNama);
        txtAlamat = findViewById(R.id.txtAlamat);
        txtPerkiraan = findViewById(R.id.txtPerkiraan);
        txtKB = findViewById(R.id.txtKB);
        txtDana = findViewById(R.id.txtDana);
        txtPetugas1 = findViewById(R.id.txtPetugas1);
        txtPetugas2 = findViewById(R.id.txtPetugas2);
        txtAmbulance1 = findViewById(R.id.txtAmbulance1);
        txtAmbulance2 = findViewById(R.id.txtAmbulance2);
        txtAmbulance3 = findViewById(R.id.txtAmbulance3);
        txtPendonor1 = findViewById(R.id.txtPendonor1);
        txtPendonor2 = findViewById(R.id.txtPendonor2);
        txtPendonor3 = findViewById(R.id.txtPendonor3);

        ImageButton btnReload = findViewById(R.id.btnLoad);
        btnReload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                loadingPersiapanPersalinan(MainActivity.username);
            }
        });

        ImageButton btnKembali = findViewById(R.id.btnKembali);
        btnKembali.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        loadingPersiapanPersalinan(MainActivity.username);
    }

    private void loadingPersiapanPersalinan(String userName){
        disableStrictMode();
        LoadingPersiapanPersalinan mLoadingData = new LoadingPersiapanPersalinan(PersiapanPersalinanActivity.this, userName);
        mLoadingData.execute("");
    }

    private class LoadingPersiapanPersalinan extends AsyncTask<String, Void, Boolean> {
        Context mContext = null;
        String user = "";
        String pass = "";

        Exception exception = null;

        LoadingPersiapanPersalinan(Context context, String userName){
            mContext = context;
            user = userName;
        }

        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(PersiapanPersalinanActivity.this);
            progressDialog.setMessage("retrieving...");
            progressDialog.setIndeterminate(false);
            progressDialog.setCancelable(false);
            progressDialog.show();
        }

        @Override
        protected Boolean doInBackground(String... arg0) {
            boolean hasilRequest=false;
            try{
                ArrayList<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
                nameValuePairs.add(new BasicNameValuePair("txtUser", user));

                HttpParams httpParameters = new BasicHttpParams();

                HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
                HttpConnectionParams.setSoTimeout(httpParameters, 15000);

                HttpClient httpclient = new DefaultHttpClient(httpParameters);
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "loadingDataPersiapan.php");
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpclient.execute(httppost);
                HttpEntity entity = response.getEntity();

                String result = EntityUtils.toString(entity);

                hasilJsonObject = new JSONObject(result);
//                hasil = jsonObject.getString("isEmpty");
//                System.out.println("hasilnya:" + hasil);
//                JSONArray uName = jsonObject.getJSONArray("username");
//                sw = new String[uName.length()];
//                for (int x=0; x<uName.length(); x++){
//                    sw[x] = uName.getString(x);
//                }
                hasilRequest=true;
            }catch (Exception e){
                Log.e("Error", "Error:", e);
                exception = e;
                hasilRequest=false;
            }

            return hasilRequest;
        }

        @Override
        protected void onPostExecute(Boolean valid){
            //StopWord = sw;
            //BtnProses.setEnabled(true);
            progressDialog.dismiss();
            if(valid){
                try {
                    ekstrakJSON();
                    if (!ambilDataJSON("adaji").equals("tidak ada")) {
                        Toast.makeText(mContext, "Loading data selesai...", Toast.LENGTH_LONG).show();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
            else{
                return;
            }

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

    @SuppressLint("SetTextI18n")
    private void ekstrakJSON() throws JSONException {
        if (ambilDataJSON("adaji").equals("tidak ada")){
            finish();
            Toast.makeText(getApplicationContext(), "Data belum dimasukkan oleh bidan...", Toast.LENGTH_LONG).show();
            return;
        }
        txtNoReg.setText(ambilDataJSON("no_reg"));
        txtNama.setText(ambilDataJSON("nama"));
        txtAlamat.setText(ambilDataJSON("alamat_rumah"));
        txtPerkiraan.setText("Bulan " + ambilDataJSON("bulan_perkiraan") + " Tahun " + ambilDataJSON("tahun_perkiraan"));
        txtKB.setText(ambilDataJSON("metode_kb"));
        txtDana.setText(ambilDataJSON("dana_persalinan"));
        txtPetugas1.setText(ambilDataJSON("nama_bidan1"));
        txtPetugas2.setText(ambilDataJSON("nama_bidan2"));

        jsonArray = hasilJsonObject.getJSONArray("ambulanceNama");
        ambulanceNama = new String[jsonArray.length()];
        for(i = 0; i<jsonArray.length(); i++){
            ambulanceNama[i] = jsonArray.getString(i);
        }

        jsonArray = hasilJsonObject.getJSONArray("ambulanceTelp");
        ambulanceTelp = new String[jsonArray.length()];
        for(i = 0; i<jsonArray.length(); i++){
            ambulanceTelp[i] = jsonArray.getString(i);
        }

        jsonArray = hasilJsonObject.getJSONArray("pendonorNama");
        pendonorNama = new String[jsonArray.length()];
        for(i = 0; i<jsonArray.length(); i++){
            pendonorNama[i] = jsonArray.getString(i);
        }

        jsonArray = hasilJsonObject.getJSONArray("pendonorTelp");
        pendonorTelp = new String[jsonArray.length()];
        for(i = 0; i<jsonArray.length(); i++){
            pendonorTelp[i] = jsonArray.getString(i);
        }

        try {
            txtAmbulance1.setText(ambulanceNama[0] + " / " + ambulanceTelp[0]);
            txtAmbulance2.setText(ambulanceNama[1] + " / " + ambulanceTelp[1]);
            txtAmbulance3.setText(ambulanceNama[2] + " / " + ambulanceTelp[2]);
        } catch (Exception e) {}
        try {
            txtPendonor1.setText(pendonorNama[0] + " / " + pendonorTelp[0]);
            txtPendonor2.setText(pendonorNama[1] + " / " + pendonorTelp[1]);
            txtPendonor3.setText(pendonorNama[2] + " / " + pendonorTelp[2]);
        } catch (Exception e) {}
    }

    private String ambilDataJSON(String field) throws JSONException {
        String hasil = null;
        hasil = hasilJsonObject.getString(field);
        if (hasil.equals("null")) hasil = "";
        return hasil;
    }
}
