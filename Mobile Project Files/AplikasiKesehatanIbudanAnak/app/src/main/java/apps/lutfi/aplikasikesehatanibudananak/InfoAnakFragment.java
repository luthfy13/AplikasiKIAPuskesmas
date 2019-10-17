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

public class InfoAnakFragment extends Fragment {
    private Intent intent;
    private ImageButton btn1, btn3;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment

        View view = inflater.inflate(R.layout.fragment_info_anak, container, false);

        btn1 = view.findViewById(R.id.btn1);
        ImageButton btn2 = view.findViewById(R.id.btn2);
        btn3 = view.findViewById(R.id.btn3);
        ImageButton btn4 = view.findViewById(R.id.btn4);
        ImageButton btn5 = view.findViewById(R.id.btn5);

        btn1.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (MainActivity.jmlAnak == 1){
                    intent = new Intent(getActivity(), KetLahir.class);
                    startActivity(intent);
                    MainActivity.halaman = 0;
                    MainActivity.judul = "";
                    MainActivity.idAnakTerpilih = MainActivity.idAnak[0];
                }
                else{
                    PopupMenu popup = new PopupMenu(getContext(), btn1);
                    popup.getMenuInflater()
                            .inflate(R.menu.popup_reg_anak, popup.getMenu());
                    for (int i=1; i<=MainActivity.jmlAnak; i++){
                        popup.getMenu().add("Anak kembar ke-" + i);
                    }
                    popup.setOnMenuItemClickListener(new PopupMenu.OnMenuItemClickListener() {
                        @Override
                        public boolean onMenuItemClick(MenuItem item) {
                            switch(item.getTitle().toString()){
                                case "Anak kembar ke-1":
                                    intent = new Intent(getActivity(), KetLahir.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[0];
                                    break;
                                case "Anak kembar ke-2":
                                    intent = new Intent(getActivity(), KetLahir.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[1];
                                    break;
                                case "Anak kembar ke-3":
                                    intent = new Intent(getActivity(), KetLahir.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[2];
                                    break;
                                case "Anak kembar ke-4":
                                    intent = new Intent(getActivity(), KetLahir.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[3];
                                    break;
                                case "Anak kembar ke-5":
                                    intent = new Intent(getActivity(), KetLahir.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[4];
                                    break;
                            }
                            return true;
                        }
                    });
                    popup.show();
                }
            }
        });

        btn2.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getActivity(), HalamanAnakActivity.class);
                startActivity(intent);
                MainActivity.halaman = 0;
                MainActivity.judul = "Bayi Baru Lahir/Neonatus (0-28hari)";
            }
        });

        btn3.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (MainActivity.jmlAnak == 1){
                    intent = new Intent(getActivity(), CatImunisasiActivity.class);
                    startActivity(intent);
                    MainActivity.halaman = 0;
                    MainActivity.judul = "";
                    MainActivity.idAnakTerpilih = MainActivity.idAnak[0];
                }
                else{
                    PopupMenu popup = new PopupMenu(getContext(), btn3);
                    popup.getMenuInflater()
                            .inflate(R.menu.popup_reg_anak, popup.getMenu());
                    for (int i=1; i<=MainActivity.jmlAnak; i++){
                        popup.getMenu().add("Anak kembar ke-" + i);
                    }
                    popup.setOnMenuItemClickListener(new PopupMenu.OnMenuItemClickListener() {
                        @Override
                        public boolean onMenuItemClick(MenuItem item) {
                            switch(item.getTitle().toString()){
                                case "Anak kembar ke-1":
                                    intent = new Intent(getActivity(), CatImunisasiActivity.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[0];
                                    break;
                                case "Anak kembar ke-2":
                                    intent = new Intent(getActivity(), CatImunisasiActivity.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[1];
                                    break;
                                case "Anak kembar ke-3":
                                    intent = new Intent(getActivity(), CatImunisasiActivity.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[2];
                                    break;
                                case "Anak kembar ke-4":
                                    intent = new Intent(getActivity(), CatImunisasiActivity.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[3];
                                    break;
                                case "Anak kembar ke-5":
                                    intent = new Intent(getActivity(), CatImunisasiActivity.class);
                                    startActivity(intent);
                                    MainActivity.halaman = 0;
                                    MainActivity.judul = "";
                                    MainActivity.idAnakTerpilih = MainActivity.idAnak[4];
                                    break;
                            }
                            return true;
                        }
                    });
                    popup.show();
                }
            }
        });

        btn4.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getActivity(), HalamanAnakActivity.class);
                startActivity(intent);
                MainActivity.halaman = 6;
                MainActivity.judul = "Anak Usia 29 Hari s.d. 6 Tahun";
            }
        });

        btn5.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                intent = new Intent(getActivity(), HalamanAnakActivity.class);
                startActivity(intent);
                MainActivity.halaman = 16;
                MainActivity.judul = "Pemenuhan kebutuhan Gizi & Perkembangan Anak";
            }
        });

        btn1.setEnabled(false);
        btn1.setImageResource(R.drawable.mn10disabled);
        btn1.setBackgroundResource(R.drawable.mn10disabled);

        btn3.setEnabled(false);
        btn3.setImageResource(R.drawable.mn7disabled);
        btn3.setBackgroundResource(R.drawable.mn7disabled);

//        btn1.set

        if (MainActivity.statusLogin.equals("login berhasil")){
            btn1.setEnabled(true);
            btn1.setImageResource(R.drawable.mn10);
            btn1.setBackgroundResource(R.drawable.mn10);

            btn3.setEnabled(true);
            btn3.setImageResource(R.drawable.mn7);
            btn3.setBackgroundResource(R.drawable.mn7);
        }

        return view;
    }
}
