<script>
    function automateLogin(flagId) {
        const linkElement = document.getElementById(flagId);

        linkElement?.addEventListener("click", (e) => {
            e.preventDefault(); // Mencegah browser langsung pindah halaman!

            console.log("🖱 Tombol tolify diklik!");
            let url = linkElement.href;
            const extensionId = "kmdekkfmjoloodbldccdiddfhilecaei";

            if (typeof chrome !== 'undefined' && chrome.runtime && chrome.runtime.sendMessage) {
                chrome.runtime.sendMessage(extensionId, {
                    action: "login",
                    url: url
                }, (response) => {
                    console.log("Respon dari ekstensi:", response);

                    // Setelah ekstensi membalas data berhasil disiapkan, baru pindah halaman
                    if (response && response.status === "success") {
                        window.open(url, '_blank');
                    } else {
                        console.error("Ekstensi gagal menyiapkan data.");
                    }
                });
            } else {
                console.warn("Ekstensi belum terinstal atau tidak terdeteksi.");
                window.location.href = url; // Fallback jika ekstensi tidak ada
            }
        });
    }

    $('#db_login').click(function() {
        const extensionId = "kmdekkfmjoloodbldccdiddfhilecaei";

        if (typeof chrome !== 'undefined' && chrome.runtime && chrome.runtime.sendMessage) {
            chrome.runtime.sendMessage(extensionId, {
                action: "saveTags"
            }, (response) => {
                console.log("Respon dari ekstensi:", response);
            });
        } else {
            console.warn("Ekstensi belum terinstal atau tidak terdeteksi.");
        }
    });


    $("document").ready(function() {

        const tombol1 = $('#con_ASU_1');
        const tombol2 = $('#con_UNAIR_1');
        const tombol3 = $('#con_UNAIR_2');
        const tombol4 = $('#con_UNAIR_3');
        const tombol5 = $('#con_UNAIR_4');

        // const socket = new WebSocket('ws://localhost:64135');

        // socket.onerror = function(error) {
        //     const btn = document.getElementById('db_login');
        //     if (btn) {
        //       btn.style.display = 'none';
        //       const pesan = document.getElementById('pesan');
        //       pesan.style.display = 'block';
        //       alert('Silahkan install agent dan ekstensi terlebih dahulu untuk mengakses database!');
        //     }
        // };

        function getOS() {
            const userAgent = navigator.userAgent || navigator.vendor || window.opera;
            const platform = navigator.platform.toLowerCase();

            if (platform.includes('win')) return 'Windows';
            if (platform.includes('mac')) return 'macOS';
            if (platform.includes('linux')) return 'Linux';
            if (/android/i.test(userAgent)) return 'Android';
            if (/iphone|ipad|ipod/i.test(userAgent)) return 'iOS';

            return 'Unknown';
        }

        console.log("Operating System:", getOS());

        if (getOS() === 'Windows') {
            window.addEventListener("message", function(event) {
                if (event.source !== window) return;
                if (event.data && event.data.from === "databaseriset" && event.data.installed ===
                    true) {
                    const minVersion = "2.0";
                    console.log("versi : ", event.data.version);
                    if (compareVersions(event.data.version, minVersion) >= 0) {
                        console.log("Ekstensi terpasang!");
                        const btn = document.getElementById('db_login');
                        if (btn) {
                            btn.style.display = 'inline';
                            const pesan = document.getElementById('pesan');
                            pesan.style.display = 'none';
                        }
                    } else {
                        const btn = document.getElementById('db_login');
                        if (btn) {
                            btn.style.display = 'none';
                            const pesan = document.getElementById('pesan');
                            pesan.style.display = 'inline';
                        }
                    }

                    // Lakukan sesuatu, misalnya: ubah UI, set cookie, dll
                }
            });

            const socket = new WebSocket('ws://localhost:64135');

            socket.onerror = function(error) {
                const btn = document.getElementById('db_login');
                if (btn) {
                    btn.style.display = 'none';
                    const pesan = document.getElementById('pesan');
                    pesan.style.display = 'block';
                    alert(
                        'Untuk pengguna Windows, silahkan install agent dan ekstensi terlebih dahulu untuk mengakses database!');
                }
            };
        }



        if (getOS() === 'macOS') {
            window.addEventListener("message", function(event) {
                if (event.source !== window) return;

                if (event.data && event.data.from === "databaseriset" && event.data.installed ===
                    true) {
                    const minVersion = "2.0";
                    console.log("versi : ", event.data.version);
                    if (compareVersions(event.data.version, minVersion) >= 0) {
                        console.log("Ekstensi terpasang!");
                        const btn = document.getElementById('db_login');
                        if (btn) {
                            btn.style.display = 'inline';
                            const pesan = document.getElementById('pesan');
                            pesan.style.display = 'none';
                        }
                    } else {
                        const btn = document.getElementById('db_login');
                        if (btn) {
                            btn.style.display = 'none';
                            const pesan = document.getElementById('pesan');
                            pesan.style.display = 'inline';
                        }
                    }
                    // Lakukan sesuatu, misalnya: ubah UI, set cookie, dll
                }
            });
        }

        // Periksa state saat halaman dimuat
        function periksaStateSaatLoad() {
            const stateTersimpan = localStorage.getItem('tombolAktif');

            // Jika state 'tombol2' tersimpan, sesuaikan tampilan
            if (stateTersimpan === 'tombol1') {
                $("#con_ASU_1").hide();
                $("#dis_ASU_1").show();
            } else if (stateTersimpan === 'tombol2') {
                $("#con_UNAIR_1").hide();
                $("#dis_UNAIR_1").show();
                $("#con_UNAIR_2").addClass("disabled");
                $("#con_UNAIR_3").addClass("disabled");
                $("#con_UNAIR_4").addClass("disabled");
            } else if (stateTersimpan === 'tombol3') {
                $("#con_UNAIR_2").hide();
                $("#dis_UNAIR_2").show();
                $("#con_UNAIR_1").addClass("disabled");
                $("#con_UNAIR_3").addClass("disabled");
                $("#con_UNAIR_4").addClass("disabled");
            } else if (stateTersimpan === 'tombol4') {
                $("#con_UNAIR_3").hide();
                $("#dis_UNAIR_3").show();
                $("#con_UNAIR_1").addClass("disabled");
                $("#con_UNAIR_2").addClass("disabled");
                $("#con_UNAIR_4").addClass("disabled");
            } else if (stateTersimpan === 'tombol5') {
                $("#con_UNAIR_4").hide();
                $("#dis_UNAIR_4").show();
                $("#con_UNAIR_1").addClass("disabled");
                $("#con_UNAIR_2").addClass("disabled");
                $("#con_UNAIR_3").addClass("disabled");
            } else {
                // Jika state 'tombol1' tidak tersimpan, sesuaikan tampilan
                $("#con_ASU_1").hide();
                $("#dis_ASU_1").hide();
                $("#con_UNAIR_1").removeClass("disabled");
                $("#con_UNAIR_2").removeClass("disabled");
                $("#con_UNAIR_3").removeClass("disabled");
                $("#con_UNAIR_4").removeClass("disabled");
            }
        }

        periksaStateSaatLoad();

        $("#filterTable").dataTable({
            "searching": true,
            "pageLength": 50
        });
        var table = $('#filterTable').DataTable();
        $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));
        var categoryIndex = 0;
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var selectedItem = $('#categoryFilter').val()
                var category = data[categoryIndex];
                if (selectedItem === "all" || selectedItem === "show" || category.includes(selectedItem)) {
                    return true;
                }
                return false;
            }
        );
        $("#categoryFilter").change(function(e) {
            table.draw();
        });
        table.draw();
    });

    /* $("#updateAgent").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "SYNC", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "", //"openvpn atau anyconnect"
                univ: "",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            // localStorage.setItem('tombolAktif', 'tombol1');

            // const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    }); */

    let socketOpen = function() {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "REGISTRY_OFF", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#db_login").addClass("d-none");
            $("#db_logout").show();
            $("#listdatabase").show();
            $("#uc_login").show();
            $("#con_ASU_1").show();
            $("#con_UNAIR_1").show();
            $("#con_UNAIR_2").show();
            $("#con_UNAIR_3").show();
            $("#con_UNAIR_4").show();
            $("#jalankan").show();
            $("#hentikan").show();
            $("#auraria").show();
            $("#oakland").show();
        };

        let retError = "";

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
            retError = error;
            return retError;
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
            retError = error;
            return retError;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    };

    // $("#db_login").click(function(e){
    // alert("Pastikan ekstensi telah terinstall jika tombol tidak melakukan aksi apapun.");
    //   socketOpen();
    //   $("#db_login").addClass("d-none");
    //   $("#db_logout").show();
    //   $("#listdatabase").show();
    //   $("#uc_login").show();
    //   $("#con_ASU_1").show();
    //   $("#con_UNAIR_1").show();
    //   $("#con_UNAIR_2").show();
    //   $("#con_UNAIR_3").show();
    //   $("#con_UNAIR_4").show();
    //   $("#jalankan").show();
    //   $("#hentikan").show();
    //   $("#auraria").show();
    //   $("#oakland").show();
    // });

    // REGISTRY_ON
    // $("#db_logout").click(function(e){
    // $("#db_login").removeClass("d-none");
    // $("#db_login").show();
    // $("#db_logout").hide();
    // $("#listdatabase").hide();
    // $("#uc_login").hide();
    // $("#con_ASU_1").hide();
    // $("#con_UNAIR_1").hide();
    // $("#con_UNAIR_2").hide();
    // $("#con_UNAIR_3").hide();
    // $("#con_UNAIR_4").hide();
    // $("#dis_ASU_1").hide();
    // $("#dis_UNAIR_1").hide();
    // $("#dis_UNAIR_2").hide();
    // $("#dis_UNAIR_3").hide();
    // $("#dis_UNAIR_4").hide();
    // $("#jalankan").hide();
    // $("#hentikan").hide();
    // $("#auraria").hide();
    // $("#oakland").hide();
    //   const statusDiv = $("#status");
    // const socket = new WebSocket('ws://localhost:64135');

    // socket.onopen = function() {
    //     statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
    //     // console.log('Koneksi berhasil dibuka.');

    //     // Siapkan data perintah dalam format JSON
    //     const perintah = {
    //         action: "REGISTRY_ON", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
    //     };

    //     // Kirim data perintah sebagai teks JSON
    //     socket.send(JSON.stringify(perintah));

    //     $("#db_login").removeClass("d-none");
    //     $("#db_login").show();
    //     $("#db_logout").hide();
    //     $("#listdatabase").hide();
    //     $("#uc_login").hide();
    //     $("#con_ASU_1").hide();
    //     $("#con_UNAIR_1").hide();
    //     $("#con_UNAIR_2").hide();
    //     $("#con_UNAIR_3").hide();
    //     $("#con_UNAIR_4").hide();
    //     $("#dis_ASU_1").hide();
    //     $("#dis_UNAIR_1").hide();
    //     $("#dis_UNAIR_2").hide();
    //     $("#dis_UNAIR_3").hide();
    //     $("#dis_UNAIR_4").hide();
    //     $("#jalankan").hide();
    //     $("#hentikan").hide();
    //     $("#auraria").hide();
    //     $("#oakland").hide();
    //   };

    //   socket.onerror = function(error) {
    //       statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
    //       console.error('WebSocket Error: ', error);
    //   };

    //   socket.onmessage = function(event) {
    //       console.log('Pesan dari server:', event.data);
    //       statusDiv.textContent = 'Status: ' + event.data;
    //   };

    //   socket.onclose = function() {
    //       console.log('Koneksi WebSocket ditutup.');
    //   };
    // });

    // Cincinnati Login
    $("#uc_login").click(function(e) {
        // socketOpen();

        const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

        // window.open("https://catalyst.uc.edu", '_blank');
        window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
    });

    // REGISTRY_CONNECT: ASU_1
    $("#con_ASU_1").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        let arizona = @json($arizonaTrim).toUpperCase();

        // console.log("ASU CONNECT", arizona);

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "anyconnect", //"openvpn atau anyconnect"
                univ: arizona,
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_ASU_1").hide();
            $("#dis_ASU_1").show();

            localStorage.setItem('tombolAktif', 'tombol1');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // REGISTRY_DISCONNECT: ASU_1
    $("#dis_ASU_1").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        let arizona = @json($arizonaTrim).toUpperCase();

        // console.log("ASU DISCONNECT": arizona_dis);

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "anyconnect", //"openvpn atau anyconnect"
                univ: arizona,
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_ASU_1").show();
            $("#dis_ASU_1").hide();

            localStorage.removeItem('tombolAktif', 'tombol1');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // REGISTRY_CONNECT: UNAIR_1
    $("#con_UNAIR_1").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        let unair = @json($unairTrim).toUpperCase();

        // console.log("UNAIR CONNECT", unair);

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "eduvpn", //"openvpn atau anyconnect"
                univ: unair,
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_1").hide();
            $("#dis_UNAIR_1").show();
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");

            localStorage.setItem('tombolAktif', 'tombol2');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';
            const extensionIds = "kmdekkfmjoloodbldccdiddfhilecaei";
            if (typeof chrome !== 'undefined' && chrome.runtime && chrome.runtime.sendMessage) {
                chrome.runtime.sendMessage(extensionIds, {
                    action: "login_button"
                }, (response) => {
                    console.log("Respon dari ekstensi:", response);
                });
            }


            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // REGISTRY_DISCONNECT: UNAIR_1
    $("#dis_UNAIR_1").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        let unair = @json($unairTrim).toUpperCase();

        // console.log("UNAIR DISCONNECT", unair);

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "eduvpn", //"openvpn atau anyconnect"
                univ: unair,
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_1").show();
            $("#dis_UNAIR_1").hide();
            $("#con_UNAIR_2").removeClass("disabled");
            $("#con_UNAIR_3").removeClass("disabled");
            $("#con_UNAIR_4").removeClass("disabled");

            localStorage.removeItem('tombolAktif', 'tombol2');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // REGISTRY_CONNECT: UNAIR_2
    $("#con_UNAIR_2").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_2",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_2").hide();
            $("#dis_UNAIR_2").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");

            localStorage.setItem('tombolAktif', 'tombol3');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // REGISTRY_DISCONNECT: UNAIR_2
    $("#dis_UNAIR_2").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_2",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_2").show();
            $("#dis_UNAIR_2").hide();
            $("#con_UNAIR_1").removeClass("disabled");
            $("#con_UNAIR_3").removeClass("disabled");
            $("#con_UNAIR_4").removeClass("disabled");

            localStorage.removeItem('tombolAktif', 'tombol3');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    const globalModal = document.getElementById('globalModal');
    globalModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const videoUrl = button.getAttribute('data-url');
        const videoTitle = button.getAttribute('data-title');

        const modalTitle = globalModal.querySelector('.modal-title');
        const iframe = globalModal.querySelector('#globalIframe');

        modalTitle.textContent = videoTitle;
        iframe.src = videoUrl;
    });

    // REGISTRY_CONNECT: UNAIR_3
    $("#con_UNAIR_3").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_3",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_3").hide();
            $("#dis_UNAIR_3").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_4").addClass("disabled");

            localStorage.setItem('tombolAktif', 'tombol4');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // REGISTRY_DISCONNECT: UNAIR_3
    $("#dis_UNAIR_3").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_3",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_3").show();
            $("#dis_UNAIR_3").hide();
            $("#con_UNAIR_1").removeClass("disabled");
            $("#con_UNAIR_2").removeClass("disabled");
            $("#con_UNAIR_4").removeClass("disabled");

            localStorage.removeItem('tombolAktif', 'tombol4');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // REGISTRY_CONNECT: UNAIR_4
    $("#con_UNAIR_4").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "CONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_4",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_4").hide();
            $("#dis_UNAIR_4").show();
            $("#con_UNAIR_1").addClass("disabled");
            $("#con_UNAIR_2").addClass("disabled");
            $("#con_UNAIR_3").addClass("disabled");

            localStorage.setItem('tombolAktif', 'tombol5');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // REGISTRY_DISCONNECT: UNAIR_4
    $("#dis_UNAIR_4").click(function(e) {
        const statusDiv = $("#status");
        const socket = new WebSocket('ws://localhost:64135');

        socket.onopen = function() {
            statusDiv.textContent = 'Status: Terhubung! Mengirim perintah...';
            // console.log('Koneksi berhasil dibuka.');

            // Siapkan data perintah dalam format JSON
            const perintah = {
                action: "DISCONNECT", // "CONNECT" atau "DISCONNECT atau REGISTRY_ON" atau "REGISTRY_OFF"
                vpn: "openvpn", //"openvpn atau anyconnect"
                univ: "UNAIR_4",
                timestamp: new Date().getTime()
            };

            // Kirim data perintah sebagai teks JSON
            socket.send(JSON.stringify(perintah));

            $("#con_UNAIR_4").show();
            $("#dis_UNAIR_4").hide();
            $("#con_UNAIR_1").removeClass("disabled");
            $("#con_UNAIR_2").removeClass("disabled");
            $("#con_UNAIR_3").removeClass("disabled");

            localStorage.removeItem('tombolAktif', 'tombol5');

            const winFeat = 'width=1024,height=768,left=100,top=100,resizable=yes';

            // window.open("https://catalyst.uc.edu", '_blank');
            // window.open("https://catalyst.uc.edu", 'Login UC', winFeat);
        };

        socket.onerror = function(error) {
            statusDiv.textContent = 'Status: Gagal terhubung! Pastikan agen lokal sudah berjalan.';
            console.error('WebSocket Error: ', error);
        };

        socket.onmessage = function(event) {
            console.log('Pesan dari server:', event.data);
            statusDiv.textContent = 'Status: ' + event.data;
        };

        socket.onclose = function() {
            console.log('Koneksi WebSocket ditutup.');
        };
    });

    // Kosongkan iframe saat modal ditutup (agar video stop otomatis)
    globalModal.addEventListener('hidden.bs.modal', function() {
        const iframe = globalModal.querySelector('#globalIframe');
        iframe.src = '';
    });

    function compareVersions(v1, v2) {
        const a = v1.split('.').map(Number);
        const b = v2.split('.').map(Number);

        // samakan panjang array (biar "2.0" dianggap sama dengan "2.0.0")
        while (a.length < b.length) a.push(0);
        while (b.length < a.length) b.push(0);

        for (let i = 0; i < a.length; i++) {
            if (a[i] > b[i]) return 1; // v1 lebih besar
            if (a[i] < b[i]) return -1; // v1 lebih kecil
        }
        return 0; // sama
    }
</script>
