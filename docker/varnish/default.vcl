vcl 4.1;

import std;

backend default {
    .host = "nginx";
    .port = "8080";
    .first_byte_timeout = 600s;
}

acl purge {
    "localhost";
    "nginx";
    "php";
    "172.16.0.0"/12;
    "10.0.0.0"/8;
    "192.168.0.0"/16;
}

sub vcl_recv {
    if (req.method == "PURGE") {
        if (!client.ip ~ purge) {
            return (synth(405, "Not allowed."));
        }
        return (purge);
    }

    if (req.method != "GET" &&
        req.method != "HEAD" &&
        req.method != "PUT" &&
        req.method != "POST" &&
        req.method != "TRACE" &&
        req.method != "OPTIONS" &&
        req.method != "DELETE") {
          return (pipe);
    }

    if (req.method != "GET" && req.method != "HEAD") {
        return (pass);
    }

    if (req.url ~ "/(admin|customer/account|checkout)") {
        return (pass);
    }

    return (hash);
}

sub vcl_backend_response {
    if (beresp.http.Cache-Control ~ "private" ||
        beresp.http.Cache-Control ~ "no-cache" ||
        beresp.http.Cache-Control ~ "no-store") {
        set beresp.ttl = 0s;
        set beresp.uncacheable = true;
    }
}

sub vcl_deliver {
    if (obj.hits > 0) {
        set resp.http.X-Magento-Cache = "HIT";
    } else {
        set resp.http.X-Magento-Cache = "MISS";
    }
}
