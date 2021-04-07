<?php
require "../users/root.php";
require "../utils/token_validation.php";

$from_web = !isset($_POST["securitykey"]);

if ($from_web
    && $ci0->getCookie("securitykey") !== $ci0->getSecuritykey()
    ) {
    $mi0->abort(-1, NULL);
} else if (!$from_web && !isset($_POST["admin"])
    ) {
    $mi0->abort(-2, NULL);
}

$admin_id = ($from_web) ? $ci0->getCookie("user_data")["pk_usuario"] : $_POST["admin"];

$mi0->begin();

$mi0->query("
    SELECT
        usuario.pk_usuario,
        usuario.nombre,
        usuario.apellido,
        usuario.telefono,
        usuario.correo,
        administrador.nombre_empresa
    FROM
        usuario
    LEFT JOIN
        (administrador)
    ON
        (administrador.fk_usuario = usuario.pk_usuario)
    WHERE pk_usuario = ?",
    $admin_id
);
if ($mi0->result->num_rows > 0) {
    $data = $mi0->result->fetch_all(MYSQLI_ASSOC)[0];
    $mi0->end("commit", 0, $data);
} else {
    $mi0->end("rollback", -4, NULL);
}