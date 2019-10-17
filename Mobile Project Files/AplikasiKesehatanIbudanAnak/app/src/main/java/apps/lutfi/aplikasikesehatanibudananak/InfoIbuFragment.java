package apps.lutfi.aplikasikesehatanibudananak;

import android.content.Intent;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageButton;
import android.widget.PopupMenu;
import android.widget.Toast;

public class InfoIbuFragment extends Fragment {
    ImageButton btn6;
    private Intent intent;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View view = inflater.inflate(R.layout.fragment_info_ibu, container, false);
        ImageButton btn1 = view.findViewById(R.id.btn1);
        ImageButton btn2 = view.findViewById(R.id.btn2);
        ImageButton btn3 = view.findViewById(R.id.btn3);
        ImageButton btn4 = view.findViewById(R.id.btn4);
        ImageButton btn5 = view.findViewById(R.id.btn5);
        btn6 = view.findViewById(R.id.btn6);

        int resID = getResources().getIdentifier("@drawable/mn0", "drawable", "apps.lutfi.aplikasikesehatanibudananak");
        System.out.println("red id: "+ resID);

        btn1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getActivity(), DaftarActivity.class);
                startActivity(intent);
                MainActivity.halaman = 0;
                MainActivity.judul = "Informasi Ibu Hamil";
            }
        });

        btn2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getActivity(), HalamanIbuActivity.class);
                startActivity(intent);
                MainActivity.halaman = 0;
                MainActivity.judul = "Informasi Ibu Hamil";
            }
        });

        btn3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getActivity(), HalamanIbuActivity.class);
                startActivity(intent);
                MainActivity.halaman = 9;
                MainActivity.judul = "Informasi Ibu Bersalin";
            }
        });

        btn4.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getActivity(), HalamanIbuActivity.class);
                startActivity(intent);
                MainActivity.halaman = 12;
                MainActivity.judul = "Informasi Ibu Nifas";
            }
        });

        btn5.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getActivity(), HalamanIbuActivity.class);
                startActivity(intent);
                MainActivity.halaman = 17;
                MainActivity.judul = "Informasi Keluarga Berencana";
            }
        });

        btn6.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                PopupMenu popup = new PopupMenu(getContext(), btn6);
                popup.getMenuInflater()
                        .inflate(R.menu.popup_menu, popup.getMenu());
//                popup.getMenu().add("wtf");
                popup.setOnMenuItemClickListener(new PopupMenu.OnMenuItemClickListener() {
                    @Override
                    public boolean onMenuItemClick(MenuItem item) {
                        switch(item.getTitle().toString()){
                            case "Catatan Kesehatan":
                                intent = new Intent(getActivity(), CatKesehatanIbuActivity.class);
                                startActivity(intent);
                                MainActivity.halaman = 0;
                                MainActivity.judul = "Informasi Ibu Hamil";
                                break;
                            case "Persiapan Persalinan":
                                intent = new Intent(getActivity(), PersiapanPersalinanActivity.class);
                                startActivity(intent);
                                MainActivity.halaman = 0;
                                MainActivity.judul = "Informasi Ibu Hamil";
                                break;
                        }
//                        Toast.makeText(
//                                getContext(),
//                                "You Clicked : " + item.getTitle(),
//                                Toast.LENGTH_SHORT
//                        ).show();
                        return true;
                    }
                });

                popup.show();
            }
        });

        btn1.setEnabled(false);
        btn1.setImageResource(R.drawable.mn0disabled);
        btn1.setBackgroundResource(R.drawable.mn0disabled);

        btn6.setEnabled(false);
        btn6.setImageResource(R.drawable.mn5disabled);
        btn6.setBackgroundResource(R.drawable.mn5disabled);

//        btn1.set

        if (MainActivity.statusLogin.equals("login berhasil")){
            btn1.setEnabled(true);
            btn1.setImageResource(R.drawable.mn0);
            btn1.setBackgroundResource(R.drawable.mn0);

            btn6.setEnabled(true);
            btn6.setImageResource(R.drawable.mn5);
            btn6.setBackgroundResource(R.drawable.mn5);
        }

        return view;
    }


}
