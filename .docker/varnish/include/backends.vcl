backend nginx {
    .host = "nginx";
    .port = "80";
    .connect_timeout = 10s;
    .first_byte_timeout = 600s;
    .between_bytes_timeout = 5s;
}