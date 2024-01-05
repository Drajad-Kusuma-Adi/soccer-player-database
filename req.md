Tables:
users

- id
- username
- password
- createdDate
- modifiedDate
  players
- id
- posisi
- nama
- nomor_punggung
- createdBy
- modifiedBy
- createdDate
- modifiedDate

Endpoints
/users/auth ->
POST-> login by checking username and password to generate JWT
/users
GET -> return all users in users table
POST -> create new user in users table
/users/{id}
GET -> return user with the id
PUT -> change value of user of current id with new one
DELETE -> remove user with current id
/players
GET -> return all players in players table
POST -> create new player in players table
/players/{id}
GET -> return player with current id
PUT -> change value of user of current id with new one
DELETE -> remove player with current id

Requirements

- login and get JWT
  Pada proses POST ke url /users/auth dilakukan validasi input dengan rule sebagai berikut : 1. Username : required, minimal 4 huruf alphanumerik 2. Password : required, minimal 6 karakter maksimal 8 karakter alhpanumerik
  Jika data yang dikirim lolos validasi maka backend melakukan 1. Enkripsi input password. 2. Membandingkan username dan password yang dikirim dengan data pada database. 3. Mengenerate dan return success response jwt token jika username dan password cocok. 4. Return error yang sesuai dengan error response jika data username dan password tidak cocok.
- return all users
  Perhatikan pada proses get /users field password tidak ikut dikembalikan.
- create new user
  Pada proses POST ke url /users dilakukan validasi input dengan rule sebagai berikut : 1. Username : minimal 4 huruf alphanumerik 2. Password : minimal 6 karakter maksimal 8 karakter alhpanumerik
  Jika data yang dikirim lolos validasi maka backend melakukan 1. Enkripsi input password. 2. Membuat created_date sesuai waktu pembuatan data. 3. Menyimpan data ke database. 4. Mengembalikan data berformat json sesuai pada Success Response. 5. Pada saat data pertama kali di create modified_date isinya kosong.
- return user by id
  Pada proses get ke url /users/:id dikembalikan data user berupa id, username, created_date dan modified_date tanpa field password.
- change user by id
  Pada proses PUT ke url /users dilakukan validasi input dengan rule sebagai berikut : 1. Username : required, minimal 4 huruf alphanumerik 2. Password : required, minimal 6 karakter maksimal 8 karakter alhpanumerik
  Jika data yang dikirim lolos validasi maka backend melakukan 1. Enkripsi input password. 2. Membuat modified_date sesuai waktu pengubahan data. 3. Mengupdate data pada database sesuai id data yang di ubah. 4. Mengembalikan data berformat json sesuai pada Success Response. 5. Created_date pada saat edit data tidak diubah.
- delete user by id
  Proses delete dilakukan dengan melakukan pengecekan input id pada url /users/:id ex /users/10. Jika terdapat data dengan id tersebut maka dilanjutkan dengan proses delet jika tidak proses dihentikan dan memberikan response sesuai Error Response

exact same thing for players i don't wanna write again
