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

public class CatKesehatanIbuActivity extends AppCompatActivity {
    private ProgressDialog progressDialog;
    private JSONObject hasilJsonObject = null;
    private EditText txtNoReg,txtNama, txtHamilKe, txtJmlPersalinan, txtJmlKeguguran, txtJmlG,
            txtJmlP, txtJmlA, txtJmlAnakHidup, txtJmlLhrMati, txtJmlAnakLhrKrgBln,
            txtJarakKehamilan, txtStatusTT, txtPenolongBersalin, txtCaraPersalinan;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cat_kesehatan_ibu);
        txtNoReg = findViewById(R.id.txtNoReg);
        txtNama = findViewById(R.id.txtNama);
        txtHamilKe = findViewById(R.id.txtHamilKe);
        txtJmlPersalinan = findViewById(R.id.txtJmlPersalinan);
        txtJmlKeguguran = findViewById(R.id.txtJmlKeguguran);
        txtJmlG = findViewById(R.id.txtJmlG);
        txtJmlP = findViewById(R.id.txtJmlP);
        txtJmlA = findViewById(R.id.txtJmlA);
        txtJmlAnakHidup = findViewById(R.id.txtJmlAnakHidup);
        txtJmlLhrMati = findViewById(R.id.txtJmlLhrMati);
        txtJmlAnakLhrKrgBln = findViewById(R.id.txtJmlAnakLhrKrgBln);
        txtJarakKehamilan = findViewById(R.id.txtJarakKehamilan);
        txtStatusTT = findViewById(R.id.txtStatusTT);
        txtPenolongBersalin = findViewById(R.id.txtPenolongBersalin);
        txtCaraPersalinan = findViewById(R.id.txtCaraPersalinan);

        ImageButton btnReload = findViewById(R.id.btnLoad);
        btnReload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                loadingCatKesehatan(MainActivity.username);
            }
        });

        ImageButton btnKembali = findViewById(R.id.btnKembali);
        btnKembali.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });

        loadingCatKesehatan(MainActivity.username);
    }

    private void loadingCatKesehatan(String userName){
        disableStrictMode();
        LoadingCatKesehatan mLoadingData = new LoadingCatKesehatan(CatKesehatanIbuActivity.this, userName);
        mLoadingData.execute("");
    }

    private class LoadingCatKesehatan extends AsyncTask<String, Void, Boolean> {
        Context mContext = null;
        String user = "";
        String pass = "";

        Exception exception = null;

        LoadingCatKesehatan(Context context, String userName){
            mContext = context;
            user = userName;
        }

        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(CatKesehatanIbuActivity.this);
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
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "loadingDataCatKesehatan.php");
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

    private void ekstrakJSON() throws JSONException {
        //EditText
        if (ambilDataJSON("adaji").equals("tidak ada")){
            finish();
            Toast.makeText(getApplicationContext(), "Data belum dimasukkan oleh bidan...", Toast.LENGTH_LONG).show();
            return;
        }
        txtNoReg.setText(ambilDataJSON("no_reg"));
        txtNama.setText(ambilDataJSON("nama"));
        txtHamilKe.setText(ambilDataJSON("hamil_ke"));
        txtJmlPersalinan.setText(ambilDataJSON("jml_persalinan"));
        txtJmlKeguguran.setText(ambilDataJSON("jml_keguguran"));
        txtJmlG.setText(ambilDataJSON("jml_gravida"));
        txtJmlP.setText(ambilDataJSON("jml_paritas"));
        txtJmlA.setText(ambilDataJSON("jml_abortus"));
        txtJmlAnakHidup.setText(ambilDataJSON("jml_anak_hidup"));
        txtJmlLhrMati.setText(ambilDataJSON("jml_lhr_mati"));
        txtJmlAnakLhrKrgBln.setText(ambilDataJSON("jml_anak_lhr_krg_bln"));
        txtJarakKehamilan.setText(ambilDataJSON("jarak_kehamilan"));
        txtStatusTT.setText(ambilDataJSON("bulan_tt") + " / " + ambilDataJSON("tahun_tt"));
        txtPenolongBersalin.setText(ambilDataJSON("penolong_persalinan"));
        if (ambilDataJSON("cara_persalinan").equals("0"))
            txtCaraPersalinan.setText("");
        else
            txtCaraPersalinan.setText(ambilDataJSON("cara_persalinan"));
    }

    private String ambilDataJSON(String field) throws JSONException {
        String hasil = null;
        hasil = hasilJsonObject.getString(field);
        if (hasil.equals("null")) hasil = "";
        return hasil;
    }
}
