<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>FOR-INV-004 - Acta de Reunión</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            margin: 35px;
            line-height: 1.4;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .title {
            font-size: 15px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 13px;
            font-weight: bold;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        .mb-30 {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .no-border td {
            border: none;
            padding: 2px;
        }

        .section {
            background: #f7f7f7;
            font-weight: bold;
        }

        .firma-box {
            height: 70px;
        }

        .small {
            font-size: 10px;
        }
    </style>
</head>
<body>

    <div class="right small mb-10">
        Bucaramanga, {{ optional($actaReunion->fecha_realizacion)->format('d/m/Y') }}
    </div>

    <div class="center mb-20">
        <div class="title">ACTA DE REUNIÓN</div>
        <div class="subtitle">FOR-INV-004</div>
    </div>

    <table class="mb-20">
        <tr>
            <td colspan="4" class="section">
                1. Información General
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <strong>Tema / Agenda propuesta:</strong><br>
                {{ $actaReunion->tema_agenda_propuesta }}
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <strong>Nombres y Apellidos investigador:</strong><br>
                {{ $actaReunion->investigador_nombre }}
            </td>
            <td colspan="2">
                <strong>Grupo de Investigación:</strong><br>
                {{ $actaReunion->grupo_investigacion }}
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <strong>Programa Académico:</strong><br>
                {{ $actaReunion->programa_academico }}
            </td>
            <td colspan="2">
                <strong>Fecha de realización:</strong><br>
                {{ optional($actaReunion->fecha_realizacion)->format('d/m/Y') }}
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <strong>Medio y/o ubicación:</strong><br>
                {{ $actaReunion->medio_ubicacion }}
            </td>
            <td>
                <strong>Hora inicial:</strong><br>
                {{ $actaReunion->hora_inicial }}
            </td>
            <td>
                <strong>Hora finaliza:</strong><br>
                {{ $actaReunion->hora_finaliza }}
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <strong>Orden del día:</strong><br>
                {{ $actaReunion->orden_dia }}
            </td>
        </tr>

        <tr>
            <td colspan="4" class="section">
                Asistentes
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <strong>Listado:</strong><br>
                {{ $actaReunion->asistentes_listado }}<br><br>

                <strong>Docentes asistentes:</strong><br>
                {{ $actaReunion->docentes_asistentes }}<br><br>

                <strong>Estudiantes asistentes:</strong><br>
                {{ $actaReunion->estudiantes_asistentes }}
            </td>
        </tr>

        <tr>
            <td colspan="4" class="section">
                Desarrollo de la reunión
            </td>
        </tr>

        <tr>
            <td colspan="4" style="height:180px;">
                {{ $actaReunion->desarrollo_reunion }}
            </td>
        </tr>

        <tr>
            <td colspan="4" class="section">
                Plan de acción
            </td>
        </tr>

        <tr>
            <th>Actividades</th>
            <th>Responsable</th>
            <th>Fecha límite</th>
            <th>Evidencia</th>
        </tr>

        <tr>
            <td colspan="4" style="height:120px;">
                {{ $actaReunion->plan_accion }}
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <strong>Eficacia de la reunión (%):</strong><br>
                {{ $actaReunion->eficacia_reunion }}
            </td>

            <td colspan="2">
                <strong>Próxima reunión</strong><br>
                Fecha: {{ optional($actaReunion->proxima_reunion_fecha)->format('d/m/Y') }}<br>
                Lugar: {{ $actaReunion->proxima_reunion_lugar }}<br>
                Hora: {{ $actaReunion->proxima_reunion_hora }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2" class="section">
                2. Firmas
            </td>
        </tr>

        <tr>
            <td class="firma-box">
                <strong>Preparado por:</strong><br><br><br>
                {{ $actaReunion->preparado_por }}<br>
                Investigador Principal / Coordinador Semillero /
                Auxiliar de investigación / Joven Investigador
            </td>

            <td class="firma-box">
                <strong>Aprobado por:</strong><br><br><br>
                {{ $actaReunion->aprobado_por }}<br>
                Líder grupo de investigación
            </td>
        </tr>

        <tr>
            <td class="firma-box">
                <strong>Revisado por:</strong><br><br><br>
                {{ $actaReunion->revisado_por }}<br>
                Docente tutor del auxiliar
            </td>

            <td class="firma-box">
                <strong>Aprobado por:</strong><br><br><br>
                MSc. Johan Hernan Pérez<br>
                Director de Investigaciones
            </td>
        </tr>
    </table>

</body>
</html>