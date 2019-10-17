package apps.lutfi.aplikasikesehatanibudananak;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.support.design.widget.NavigationView;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
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
import org.json.JSONObject;

import java.lang.reflect.Constructor;
import java.lang.reflect.Method;
import java.util.ArrayList;

public class LoginActivity extends AppCompatActivity {

    private ProgressDialog progressDialog;
    private String hasil = null;
    private MenuItem mnLogin;
    private Intent intentForm;
    private JSONArray jsonArray;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        final EditText txtUser = findViewById(R.id.txtUser);
        final EditText txtPwd = findViewById(R.id.txtPwd);
        Button btnLogin = findViewById(R.id.btnLogin);

        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                prosesLogin(txtUser.getText().toString(), txtPwd.getText().toString());
            }
        });



    }

    private void prosesLogin(String userName, String pwd){
        disableStrictMode();
        prosesLogin mprosesLogin = new prosesLogin(LoginActivity.this, userName, pwd);
        mprosesLogin.execute("");
    }

    private class prosesLogin extends AsyncTask<String, Void, Boolean> {
        Context mContext = null;
        String user = "";
        String pass = "";

        Exception exception = null;

        prosesLogin(Context context, String userName, String password){
            mContext = context;
            user = userName;
            pass = password;
        }

        @Override
        protected void onPreExecute() {
            progressDialog = new ProgressDialog(LoginActivity.this);
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
                nameValuePairs.add(new BasicNameValuePair("txtPwd", pass));

                HttpParams httpParameters = new BasicHttpParams();

                HttpConnectionParams.setConnectionTimeout(httpParameters, 15000);
                HttpConnectionParams.setSoTimeout(httpParameters, 15000);

                HttpClient httpclient = new DefaultHttpClient(httpParameters);
                HttpPost httppost = new HttpPost(MainActivity.urlServer + "loginAndroid.php");
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
                HttpResponse response = httpclient.execute(httppost);
                HttpEntity entity = response.getEntity();

                String result = EntityUtils.toString(entity);

                JSONObject jsonObject = new JSONObject(result);
                hasil = jsonObject.getString("isEmpty");
                MainActivity.jmlAnak = jsonObject.getInt("jmlAnak");
                System.out.println("hasilnya:" + hasil);

                jsonArray = jsonObject.getJSONArray("idAnak");
                MainActivity.idAnak = new String[jsonArray.length()];
                for (int i=0; i<jsonArray.length(); i++){
                    MainActivity.idAnak[i] = jsonArray.getString(i);
                }
                hasilRequest = true;
//                JSONArray uName = jsonObject.getJSONArray("username");
//                sw = new String[uName.length()];
//                for (int x=0; x<uName.length(); x++){
//                    sw[x] = uName.getString(x);
//                }

            }catch (Exception e){
                Log.e("Error", "Error:", e);
                exception = e;
                hasilRequest = false;
            }

            return hasilRequest;
        }

        @Override
        protected void onPostExecute(Boolean valid){
            //StopWord = sw;
            //BtnProses.setEnabled(true);
            progressDialog.dismiss();
            if (valid){
                if(hasil.equals("true")){
                    MainActivity.statusLogin = "belum login";
                    Toast.makeText(mContext, "Login gagal...", Toast.LENGTH_SHORT).show();
                    //System.exit(0);
                }
                else{
                    MainActivity.statusLogin = "login berhasil";
                    MainActivity.mnLogin.setTitle("Logout");
                    MainActivity.mnSetting.setVisible(true);
                    MainActivity.username = user;
                    LoginActivity.this.finish();
                    intentForm = new Intent(LoginActivity.this, InfoIbuAnakActivity.class);
                    startActivity(intentForm);
//                MainActivity.navigationView.setNavigationItemSelectedListener();
//                NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
//                Menu nv = navigationView.getMenu();
//                MenuItem item = nv.findItem(R.id.mnLogin);
//                mnLogin.setTitle("Logout");
                    Toast.makeText(mContext, "Login berhasil...", Toast.LENGTH_LONG).show();
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
}
