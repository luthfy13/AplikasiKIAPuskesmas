package apps.lutfi.aplikasikesehatanibudananak;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.ImageView;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    public static int halaman;
    public static String judul;
    private static Intent intentForm;
    private static int idForm = 0;
    public static String statusLogin = "belum login", username = "";
    public static Menu menu;
    public static NavigationView navigationView;
    public static int jmlAnak=0;
    public static String[] idAnak;
    public static String idAnakTerpilih;
    public static MenuItem mnLogin, mnSetting;
    private boolean doubleBackToExitPressedOnce = false;
    public static String urlServer = "http://kia-segeri.com/bidan/";
//    public static String urlServer = "http://kia-marang.com/";


    @SuppressLint("ClickableViewAccessibility")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        ImageView imgSampul = findViewById(R.id.imgSampul);

        imgSampul.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intentForm = new Intent(MainActivity.this, InfoIbuAnakActivity.class);
                startActivity(intentForm);
                idForm = 0;
            }
        });

        menu = navigationView.getMenu();
        mnLogin = menu.findItem(R.id.mnLogin);
        mnSetting = menu.findItem(R.id.mnSetting);
        mnLogin.setTitle("Login");
        mnSetting.setVisible(false);
        navigationView.setNavigationItemSelectedListener(this);


    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            if (doubleBackToExitPressedOnce) {
                super.onBackPressed();
                return;
            }

            this.doubleBackToExitPressedOnce = true;
            Toast.makeText(this, "Tekan tombol BACK dua kali untuk keluar dari aplikasi", Toast.LENGTH_SHORT).show();

            new Handler().postDelayed(new Runnable() {

                @Override
                public void run() {
                    doubleBackToExitPressedOnce=false;
                }
            }, 2000);
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        idForm = item.getItemId();

//        if (id == R.id.mnLogin) {
//            intentForm = new Intent(MainActivity.this, LoginActivity.class);
//            startActivity(intentForm);
//        }
//        else if (id == R.id.mnDataIbu) {
//            intentForm = new Intent(MainActivity.this, DaftarActivity.class);
//            startActivity(intentForm);
//        }
//        else if (id == R.id.mnDataBayi) {
//            intentForm = new Intent(MainActivity.this, DataBayiActivity.class);
//            startActivity(intentForm);
//        }
//        else if (id == R.id.mnInformasi) {
//            idForm = R.id.mnInformasi;
//        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.addDrawerListener(new DrawerLayout.DrawerListener() {
            @Override
            public void onDrawerSlide(View drawerView, float slideOffset) {

            }

            @Override
            public void onDrawerOpened(View drawerView) {

            }

            @Override
            public void onDrawerClosed(View drawerView) {
                switch (idForm){
                    case R.id.mnInformasi:
                        intentForm = new Intent(MainActivity.this, InfoIbuAnakActivity.class);
                        startActivity(intentForm);
                        idForm = 0;
                        break;
                    case R.id.mnSetting:
                        intentForm = new Intent(MainActivity.this, SettingAkunActivity.class);
                        startActivity(intentForm);
                        idForm = 0;
                        break;
                    case R.id.mnLogin:
                        System.out.println("Status Login: " + statusLogin);
                        if (statusLogin.equals("belum login")) {
                            intentForm = new Intent(MainActivity.this, LoginActivity.class);
                            startActivity(intentForm);

                        }
                        else{
                            mnLogin.setTitle("Login");
                            mnSetting.setVisible(false);
                            statusLogin = "belum login";
                            Toast.makeText(getApplicationContext(), "Logout sukses...", Toast.LENGTH_LONG).show();
                        }
                        idForm = 0;
                        break;
                }
            }

            @Override
            public void onDrawerStateChanged(int newState) {

            }
        });
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
}
