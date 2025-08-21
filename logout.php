 <?php
            session_start();
            session_unset();
            session_destroy();
            // Pastikan tidak ada output lain sebelum script ini
            echo "<script>
                alert('Anda telah berhasil logout!');
                window.location.href = 'index.php';
            </script>";
            exit(); 
?