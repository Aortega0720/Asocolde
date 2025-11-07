<?php

/**
 * @file
 * Contains \Drupal\asocol_migrate\Plugin\migrate\source\AsocoldermaUser.
 */

namespace Drupal\asocol_migrate\Plugin\migrate\source;

use Drupal\migrate\Row;
use Drupal\file\Entity\File;
use Drupal\Core\File\FileSystemInterface;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\migrate\Plugin\migrate\source\SqlBase;

/**
 * Extract users from Drupal 7 database.
 *
 * @MigrateSource(
 *   id = "asocolderma_user"
 * )
 */
class AsocoldermaUser extends AsocoldermaMigration {

  /**
   * {@inheritdoc}
   */
  public function query(): SelectInterface {
    return $this->select('users', 'u')
      ->fields('u', array_keys($this->baseFields()))
      ->condition('uid', 1, '>')
      ->condition('init', 'hormigah@gmail.com', '!=');
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = $this->baseFields();
    $fields['field_recibir_notificaciones'] = 'Recibir notificaciones de la Asociación en su perfil';
    $fields['field_nombres'] = 'Primer Nombre';

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    $uid = $row->getSourceProperty('uid');

    // roles
    $query = $this->select('users_roles', 'r');
    $query->fields('r', ['rid']);
    $query->condition('r.uid', $uid, '=');
    $result = $query->execute();
    $roles = [];
    foreach ($result as $record) {
      $roles[] = $record['rid'];
    }
    if(!empty($roles)) {
      $row->setSourceProperty('roles', $roles);
    }

    // field_recibir_notificaciones
    $row->setSourceProperty(
      'field_recibir_notificaciones',
      $this->getFieldValue('field_data_field_recibir_notificaciones', 'field_recibir_notificaciones_value', 'user', $uid)
    );

    // field_mostrar_mi_perfil_a_los_pa
    $row->setSourceProperty(
      'field_mostrar_mi_perfil_a_los_pa',
      $this->getFieldValue('field_data_field_mostrar_mi_perfil_a_los_pa', 'field_mostrar_mi_perfil_a_los_pa_value', 'user', $uid)
    );

    // field_mostrar_servicios
    $row->setSourceProperty(
      'field_mostrar_servicios',
      $this->getFieldValue('field_data_field_mostrar_servicios', 'field_mostrar_servicios_value', 'user', $uid)
    );

    // field_participar_re_certificacio
    $row->setSourceProperty(
      'field_participar_re_certificacio',
      $this->getFieldValue('field_data_field_participar_re_certificacio', 'field_participar_re_certificacio_value', 'user', $uid)
    );

    // field_nombres
    $row->setSourceProperty(
      'field_nombres',
      $this->getFieldValue('field_data_field_nombres', 'field_nombres_value', 'user', $uid)
    );

    // field_segundo_nombre
    $row->setSourceProperty(
      'field_segundo_nombre',
      $this->getFieldValue('field_data_field_segundo_nombre', 'field_segundo_nombre_value', 'user', $uid)
    );

    // field_apellidos
    $row->setSourceProperty(
      'field_apellidos',
      $this->getFieldValue('field_data_field_apellidos', 'field_apellidos_value', 'user', $uid)
    );

    // field_segundo_apellido
    $row->setSourceProperty(
      'field_segundo_apellido',
      $this->getFieldValue('field_data_field_segundo_apellido', 'field_segundo_apellido_value', 'user', $uid)
    );

    // field_sexo
    $row->setSourceProperty(
      'field_sexo',
      $this->getFieldValue('field_data_field_sexo', 'field_sexo_value', 'user', $uid)
    );

    // field_field_user_avatar
    $image_data = $this->getFieldImage(
      'field_data_field_field_user_avatar',
      'field_field_user_avatar_fid',
      'field_field_user_avatar_title',
      'field_field_user_avatar_alt',
      'user',
      $uid,
      $uid,
      'public://user'
    );
    if ($image_data) {
      $row->setSourceProperty(
        'field_field_user_avatar_fid',
        $image_data['fid']
      );
      $row->setSourceProperty(
        'field_field_user_avatar_alt',
        $image_data['alt']
      );
      $row->setSourceProperty(
        'field_field_user_avatar_title',
        $image_data['title']
      );
    }

    // field_titulo_universitario
    $row->setSourceProperty(
      'field_titulo_universitario',
      $this->getFieldTaxonomyTerm('field_data_field_titulo_universitario', 'field_titulo_universitario_tid', 'user', $uid, 'university_degree')
    );

    // field_ciudad
    $row->setSourceProperty(
      'field_ciudad',
      $this->getFieldTaxonomyTerm('field_data_field_ciudad', 'field_ciudad_tid', 'user', $uid, 'city')
    );

    // field_email_publico
    $row->setSourceProperty(
      'field_email_publico',
      $this->getFieldValue('field_data_field_email_publico', 'field_email_publico_value', 'user', $uid)
    );

    // field_sitio_web
    $row->setSourceProperty(
      'field_sitio_web',
      $this->getFieldValue('field_data_field_sitio_web', 'field_sitio_web_value', 'user', $uid)
    );

    // field_horario_de_atencion
    $row->setSourceProperty(
      'field_horario_de_atencion',
      $this->getFieldValue('field_data_field_horario_de_atencion', 'field_horario_de_atencion_value', 'user', $uid)
    );

    // field_telefono
    $row->setSourceProperty(
      'field_telefono',
      $this->getFieldValue('field_data_field_telefono', 'field_telefono_value', 'user', $uid)
    );

    // field_telefono_2
    $row->setSourceProperty(
      'field_telefono_2',
      $this->getFieldValue('field_data_field_telefono_2', 'field_telefono_2_value', 'user', $uid)
    );

    // field_telefono_2
    $row->setSourceProperty(
      'field_telefono_2',
      $this->getFieldValue('field_data_field_telefono_2', 'field_telefono_2_value', 'user', $uid)
    );

    // field_informacion_de_perfil
    $row->setSourceProperty(
      'field_informacion_de_perfil',
      strip_tags($this->getFieldValue('field_data_field_informacion_de_perfil', 'field_informacion_de_perfil_value', 'user', $uid))
    );

    // field_facultad_de_medicina
    $row->setSourceProperty(
      'field_facultad_de_medicina',
      $this->getFieldTaxonomyTerm('field_data_field_facultad_de_medicina', 'field_facultad_de_medicina_tid', 'user', $uid, 'medicine_school')
    );

    // field_universidad_de_residencia
    $row->setSourceProperty(
      'field_universidad_de_residencia',
      $this->getFieldTaxonomyTerm('field_data_field_universidad_de_residencia', 'field_universidad_de_residencia_tid', 'user', $uid, 'university_residence')
    );

    // field_imagen_consultorio
    $image_data = [];
    $image_data1 = $this->getFieldImage(
      'field_data_field_imagen_consultorio_1',
      'field_imagen_consultorio_1_fid',
      'field_imagen_consultorio_1_title',
      'field_imagen_consultorio_1_alt',
      'user',
      $uid,
      $uid,
      'public://consultorio'
    );
    if(!empty($image_data1)) {
      $image_data[] = $image_data1;
    }
    $image_data2 = $this->getFieldImage(
      'field_data_field_imagen_consultorio_2',
      'field_imagen_consultorio_2_fid',
      'field_imagen_consultorio_2_title',
      'field_imagen_consultorio_2_alt',
      'user',
      $uid,
      $uid,
      'public://consultorio'
    );
    if(!empty($image_data2)) {
      $image_data[] = $image_data2;
    }
    if (!empty($image_data)) {
      $row->setSourceProperty('field_imagen_consultorio', $image_data);
    }

    // field_acepto_terminos
    $row->setSourceProperty(
      'field_acepto_terminos',
      $this->getFieldValue('field_data_field_acepto_terminos', 'field_acepto_terminos_value', 'user', $uid)
    );

    // field_direccion_most
    $row->setSourceProperty(
      'field_direccion_most',
      $this->getFieldValue('field_data_field_direccion_most', 'field_direccion_most_value', 'user', $uid)
    );

    // field_ubicacion_mapa
    $geolocation = $this->getFieldGeolocation(
      'field_data_field_ubicacion_mapa',
      'field_ubicacion_mapa_lat',
      'field_ubicacion_mapa_lng',
      'field_ubicacion_mapa_lat_sin',
      'field_ubicacion_mapa_lat_cos',
      'field_ubicacion_mapa_lng_rad',
      'user',
      $uid
    );
    if(!empty($geolocation)) {
      $row->setSourceProperty('field_ubicacion_mapa_lat', $geolocation->lat);
      $row->setSourceProperty('field_ubicacion_mapa_lng', $geolocation->lng);
      $row->setSourceProperty('field_ubicacion_mapa_lat_sin', $geolocation->lat_sin);
      $row->setSourceProperty('field_ubicacion_mapa_lat_cos', $geolocation->lat_cos);
      $row->setSourceProperty('field_ubicacion_mapa_lng_rad', $geolocation->lng_rad);
    }

    // field_correo_electronico_persona
    $row->setSourceProperty(
      'field_correo_electronico_persona',
      $this->getFieldValue('field_data_field_correo_electronico_persona', 'field_correo_electronico_persona_value', 'user', $uid)
    );

    // field_telefono_fijo_residencia
    $row->setSourceProperty(
      'field_telefono_fijo_residencia',
      $this->getFieldValue('field_data_field_telefono_fijo_residencia', 'field_telefono_fijo_residencia_value', 'user', $uid)
    );

    // field_direccion_de_residencia
    $row->setSourceProperty(
      'field_direccion_de_residencia',
      $this->getFieldValue('field_data_field_direccion_de_residencia', 'field_direccion_de_residencia_value', 'user', $uid)
    );

    // field_celular
    $row->setSourceProperty(
      'field_celular',
      $this->getFieldValue('field_data_field_celular', 'field_celular_value', 'user', $uid)
    );

    // field_recibir_correspondencia
    $row->setSourceProperty(
      'field_recibir_correspondencia',
      $this->getFieldValue('field_data_field_recibir_correspondencia', 'field_recibir_correspondencia_value', 'user', $uid)
    );

    // field_servicios_y_especialidades
    $row->setSourceProperty(
      'field_servicios_y_especialidades',
      $this->getFieldTaxonomyTerm('field_data_field_servicios_y_especialidades', 'field_servicios_y_especialidades_tid', 'user', $uid, 'services_specialties', TRUE)
    );

    // field_tratamientos_laser
    $row->setSourceProperty(
      'field_tratamientos_laser',
      $this->getFieldValue('field_data_field_tratamientos_laser', 'field_tratamientos_laser_value', 'user', $uid)
    );

    // field_otra_especialidad
    $row->setSourceProperty(
      'field_otra_especialidad',
      $this->getFieldValue('field_data_field_otra_especialidad', 'field_otra_especialidad_value', 'user', $uid)
    );

    // field_tags_perfil
    $row->setSourceProperty(
      'field_tags_perfil',
      $this->getFieldTaxonomyTerm('field_data_field_tags_perfil', 'field_tags_perfil_tid', 'user', $uid, 'tags', TRUE)
    );

    // field_estado_afiliacion
    $row->setSourceProperty(
      'field_estado_afiliacion',
      $this->getFieldValue('field_data_field_estado_afiliacion', 'field_estado_afiliacion_value', 'user', $uid)
    );

    // field_tipo_de_documento
    $row->setSourceProperty(
      'field_tipo_de_documento',
      $this->getFieldValue('field_data_field_tipo_de_documento', 'field_tipo_de_documento_value', 'user', $uid)
    );

    // field_no_identificacion
    $row->setSourceProperty(
      'field_no_identificacion',
      $this->getFieldValue('field_data_field_no_identificacion', 'field_no_identificacion_value', 'user', $uid)
    );

    // field_pais
    $row->setSourceProperty(
      'field_pais',
      $this->getFieldTaxonomyTerm('field_data_field_pais', 'field_pais_tid', 'user', $uid, 'country')
    );

    // field_tipo_de_asociado
    $row->setSourceProperty(
      'field_tipo_de_asociado',
      $this->getFieldValue('field_data_field_tipo_de_asociado', 'field_tipo_de_asociado_value', 'user', $uid)
    );

    // field_no_celular_del_consultorio
    $row->setSourceProperty(
      'field_no_celular_del_consultorio',
      $this->getFieldValue('field_data_field_no_celular_del_consultorio', 'field_no_celular_del_consultorio_value', 'user', $uid)
    );

    // field_tel_fono_del_consultorio
    $row->setSourceProperty(
      'field_tel_fono_del_consultorio',
      $this->getFieldValue('field_data_field_tel_fono_del_consultorio', 'field_tel_fono_del_consultorio_value', 'user', $uid)
    );

    // field_fecha_de_nacimiento
    $date_text = $this->getFieldValue('field_data_field_fecha_de_nacimiento', 'field_fecha_de_nacimiento_value', 'user', $uid);
    if(!empty($date_text)) {
      $pieces = explode(' ', $date_text);
      if(!empty($pieces[0])) {
        $row->setSourceProperty('field_fecha_de_nacimiento', $pieces[0]);
      }
    }

    // field_estado_civil_
    $row->setSourceProperty(
      'field_estado_civil_',
      $this->getFieldValue('field_data_field_estado_civil_', 'field_estado_civil__value', 'user', $uid)
    );

    // field_departamento
    $row->setSourceProperty(
      'field_departamento',
      $this->getFieldValue('field_data_field_departamento', 'field_departamento_value', 'user', $uid)
    );

    // field_universidad_de_pregrado
    $row->setSourceProperty(
      'field_universidad_de_pregrado',
      $this->getFieldTaxonomyTerm('field_data_field_universidad_de_pregrado', 'field_universidad_de_pregrado_tid', 'user', $uid, 'university_undergraduate')
    );

    // field_registro_medico
    $row->setSourceProperty(
      'field_registro_medico',
      $this->getFieldValue('field_data_field_registro_medico', 'field_registro_medico_value', 'user', $uid)
    );

    // field_field_anos_residencia
    $row->setSourceProperty(
      'field_field_anos_residencia',
      $this->getFieldValue('field_data_field_field_anos_residencia', 'field_field_anos_residencia_value', 'user', $uid)
    );

    // field_fecha_post_grado
    $date_text = $this->getFieldValue('field_data_field_fecha_post_grado', 'field_fecha_post_grado_value', 'user', $uid);
    if(!empty($date_text)) {
      $pieces = explode(' ', $date_text);
      if(!empty($pieces[0])) {
        $row->setSourceProperty('field_fecha_post_grado', $pieces[0]);
      }
    }

    // field_universidad_de_subespecial
    $row->setSourceProperty(
      'field_universidad_de_subespecial',
      $this->getFieldValue('field_data_field_universidad_de_subespecial', 'field_universidad_de_subespecial_value', 'user', $uid)
    );

    // field_nombre_de_la_subespecialid
    $row->setSourceProperty(
      'field_nombre_de_la_subespecialid',
      $this->getFieldValue('field_data_field_nombre_de_la_subespecialid', 'field_nombre_de_la_subespecialid_value', 'user', $uid)
    );

    // field_fecha_de_grado_de_subespec
    $date_text = $this->getFieldValue('field_data_field_fecha_de_grado_de_subespec', 'field_fecha_de_grado_de_subespec_value', 'user', $uid);
    if(!empty($date_text)) {
      $pieces = explode(' ', $date_text);
      if(!empty($pieces[0])) {
        $row->setSourceProperty('field_fecha_de_grado_de_subespec', $pieces[0]);
      }
    }

    // field_anos_subespecialidad
    $row->setSourceProperty(
      'field_anos_subespecialidad',
      $this->getFieldValue('field_data_field_anos_subespecialidad', 'field_anos_subespecialidad_value', 'user', $uid)
    );

    // field_asociado_presentan1
    $row->setSourceProperty(
      'field_asociado_presentan1',
      $this->getFieldValue('field_data_field_asociado_presentan1', 'field_asociado_presentan1_value', 'user', $uid)
    );

    // field_asociado_presentan_2
    $row->setSourceProperty(
      'field_asociado_presentan_2',
      $this->getFieldValue('field_data_field_asociado_presentan_2', 'field_asociado_presentan_2_value', 'user', $uid)
    );

    // field_field_carta_ingreso
    $file_data = $this->getFieldFile(
      'field_data_field_field_carta_ingreso',
      'field_field_carta_ingreso_fid',
      'field_field_carta_ingreso_display',
      'field_field_carta_ingreso_description',
      'user',
      $uid,
      $uid,
      'public://admissions'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_field_carta_ingreso_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_field_carta_ingreso_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_field_carta_ingreso_description',
        $file_data['description']
      );
    }

    // field_field_dc_scanner
    $file_data = $this->getFieldFile(
      'field_data_field_field_dc_scanner',
      'field_field_dc_scanner_fid',
      'field_field_dc_scanner_display',
      'field_field_dc_scanner_description',
      'user',
      $uid,
      $uid,
      'public://document'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_field_dc_scanner_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_field_dc_scanner_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_field_dc_scanner_description',
        $file_data['description']
      );
    }

    // field_hoja_de_vida
    $file_data = $this->getFieldFile(
      'field_data_field_hoja_de_vida',
      'field_hoja_de_vida_fid',
      'field_hoja_de_vida_display',
      'field_hoja_de_vida_description',
      'user',
      $uid,
      $uid,
      'public://cv'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_hoja_de_vida_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_hoja_de_vida_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_hoja_de_vida_description',
        $file_data['description']
      );
    }

    // field_rut
    $file_data = $this->getFieldFile(
      'field_data_field_rut',
      'field_rut_fid',
      'field_rut_display',
      'field_rut_description',
      'user',
      $uid,
      $uid,
      'public://rut'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_rut_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_rut_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_rut_description',
        $file_data['description']
      );
    }

    // field_diploma_pregrado
    $file_data = $this->getFieldFile(
      'field_data_field_diploma_pregrado',
      'field_diploma_pregrado_fid',
      'field_diploma_pregrado_display',
      'field_diploma_pregrado_description',
      'user',
      $uid,
      $uid,
      'public://diploma'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_diploma_pregrado_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_diploma_pregrado_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_diploma_pregrado_description',
        $file_data['description']
      );
    }

    // field_diploma_especializacion
    $file_data = $this->getFieldFile(
      'field_data_field_diploma_especializacion',
      'field_diploma_especializacion_fid',
      'field_diploma_especializacion_display',
      'field_diploma_especializacion_description',
      'user',
      $uid,
      $uid,
      'public://diploma'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_diploma_especializacion_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_diploma_especializacion_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_diploma_especializacion_description',
        $file_data['description']
      );
    }

    // field_acta_de_grado_especializac
    $file_data = $this->getFieldFile(
      'field_data_field_acta_de_grado_especializac',
      'field_acta_de_grado_especializac_fid',
      'field_acta_de_grado_especializac_display',
      'field_acta_de_grado_especializac_description',
      'user',
      $uid,
      $uid,
      'public://certificate'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_acta_de_grado_especializac_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_acta_de_grado_especializac_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_acta_de_grado_especializac_description',
        $file_data['description']
      );
    }

    // field_acta_de_grado_pregrado
    $file_data = $this->getFieldFile(
      'field_data_field_acta_de_grado_pregrado',
      'field_acta_de_grado_pregrado_fid',
      'field_acta_de_grado_pregrado_display',
      'field_acta_de_grado_pregrado_description',
      'user',
      $uid,
      $uid,
      'public://certificate'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_acta_de_grado_pregrado_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_acta_de_grado_pregrado_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_acta_de_grado_pregrado_description',
        $file_data['description']
      );
    }

    // field_carta_asociado_1
    $file_data = $this->getFieldFile(
      'field_data_field_carta_asociado_1',
      'field_carta_asociado_1_fid',
      'field_carta_asociado_1_display',
      'field_carta_asociado_1_description',
      'user',
      $uid,
      $uid,
      'public://recommendation'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_carta_asociado_1_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_carta_asociado_1_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_carta_asociado_1_description',
        $file_data['description']
      );
    }

    // field_carta_asociado_2
    $file_data = $this->getFieldFile(
      'field_data_field_carta_asociado_2',
      'field_carta_asociado_2_fid',
      'field_carta_asociado_2_display',
      'field_carta_asociado_2_description',
      'user',
      $uid,
      $uid,
      'public://recommendation'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_carta_asociado_2_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_carta_asociado_2_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_carta_asociado_2_description',
        $file_data['description']
      );
    }

    // field_tarjeta_profesional
    $file_data = $this->getFieldFile(
      'field_data_field_tarjeta_profesional',
      'field_tarjeta_profesional_fid',
      'field_tarjeta_profesional_display',
      'field_tarjeta_profesional_description',
      'user',
      $uid,
      $uid,
      'public://professional'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_tarjeta_profesional_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_tarjeta_profesional_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_tarjeta_profesional_description',
        $file_data['description']
      );
    }

    // field_pdf_puntaje_rec_camec
    $file_data = $this->getFieldFile(
      'field_data_field_pdf_puntaje_rec_camec',
      'field_pdf_puntaje_rec_camec_fid',
      'field_pdf_puntaje_rec_camec_display',
      'field_pdf_puntaje_rec_camec_description',
      'user',
      $uid,
      $uid,
      'public://camec'
    );
    if ($file_data) {
      $row->setSourceProperty(
        'field_pdf_puntaje_rec_camec_fid',
        $file_data['fid']
      );
      $row->setSourceProperty(
        'field_pdf_puntaje_rec_camec_display',
        $file_data['display']
      );
      $row->setSourceProperty(
        'field_pdf_puntaje_rec_camec_description',
        $file_data['description']
      );
    }

    // field_congreso_nacional_de_derma
    $row->setSourceProperty(
      'field_congreso_nacional_de_derma',
      $this->getFieldValue('field_data_field_congreso_nacional_de_derma', 'field_congreso_nacional_de_derma_value', 'user', $uid)
    );

    // field_congreso_de_especialidades
    $row->setSourceProperty(
      'field_congreso_de_especialidades',
      $this->getFieldValue('field_data_field_congreso_de_especialidades', 'field_congreso_de_especialidades_value', 'user', $uid)
    );

    // field_autor_art_culo_revista_aso
    $row->setSourceProperty(
      'field_autor_art_culo_revista_aso',
      $this->getFieldValue('field_data_field_autor_art_culo_revista_aso', 'field_autor_art_culo_revista_aso_value', 'user', $uid)
    );

    // field_puntos_por_pertenecer_a_un
    $row->setSourceProperty(
      'field_puntos_por_pertenecer_a_un',
      $this->getFieldValue('field_data_field_puntos_por_pertenecer_a_un', 'field_puntos_por_pertenecer_a_un_value', 'user', $uid)
    );

    // field_congresos_nacionales_e_int
    $row->setSourceProperty(
      'field_congresos_nacionales_e_int',
      $this->getFieldValue('field_data_field_congresos_nacionales_e_int', 'field_congresos_nacionales_e_int_value', 'user', $uid)
    );

    // field_en_su_consultorio_particul
    $row->setSourceProperty(
      'field_en_su_consultorio_particul',
      $this->getFieldValue('field_data_field_en_su_consultorio_particul', 'field_en_su_consultorio_particul_value', 'user', $uid)
    );

    // field_dermatologo_recertificado
    $row->setSourceProperty(
      'field_dermatologo_recertificado',
      $this->getFieldValue('field_data_field_dermatologo_recertificado', 'field_dermatologo_recertificado_value', 'user', $uid)
    );

    // field_editoriales_cartas_al_comi
    $row->setSourceProperty(
      'field_editoriales_cartas_al_comi',
      $this->getFieldValue('field_data_field_editoriales_cartas_al_comi', 'field_editoriales_cartas_al_comi_value', 'user', $uid)
    );

    // field_art_culo_de_investigaci_n_
    $row->setSourceProperty(
      'field_art_culo_de_investigaci_n_',
      $this->getFieldValue('field_data_field_art_culo_de_investigaci_n_', 'field_art_culo_de_investigaci_n__value', 'user', $uid)
    );

    // field_art_culo_o_contenido_para_
    $row->setSourceProperty(
      'field_art_culo_o_contenido_para_',
      $this->getFieldValue('field_data_field_art_culo_o_contenido_para_', 'field_art_culo_o_contenido_para__value', 'user', $uid)
    );

    // field_autor_de_cap_tulo_de_libro
    $row->setSourceProperty(
      'field_autor_de_cap_tulo_de_libro',
      $this->getFieldValue('field_data_field_autor_de_cap_tulo_de_libro', 'field_autor_de_cap_tulo_de_libro_value', 'user', $uid)
    );

    // field_autor_o_editor_de_libro_de
    $row->setSourceProperty(
      'field_autor_o_editor_de_libro_de',
      $this->getFieldValue('field_data_field_autor_o_editor_de_libro_de', 'field_autor_o_editor_de_libro_de_value', 'user', $uid)
    );

    // field_editor_de_revista_cient_fi
    $row->setSourceProperty(
      'field_editor_de_revista_cient_fi',
      $this->getFieldValue('field_data_field_editor_de_revista_cient_fi', 'field_editor_de_revista_cient_fi_value', 'user', $uid)
    );

    // field_miembro_de_comit_editorial
    $row->setSourceProperty(
      'field_miembro_de_comit_editorial',
      $this->getFieldValue('field_data_field_miembro_de_comit_editorial', 'field_miembro_de_comit_editorial_value', 'user', $uid)
    );

    // field_miembro_de_comit_cient_fic
    $row->setSourceProperty(
      'field_miembro_de_comit_cient_fic',
      $this->getFieldValue('field_data_field_miembro_de_comit_cient_fic', 'field_miembro_de_comit_cient_fic_value', 'user', $uid)
    );

    // field_presidente_junta_directiva
    $row->setSourceProperty(
      'field_presidente_junta_directiva',
      $this->getFieldValue('field_data_field_presidente_junta_directiva', 'field_presidente_junta_directiva_value', 'user', $uid)
    );

    // field_miembro_de_junta_directiva
    $row->setSourceProperty(
      'field_miembro_de_junta_directiva',
      $this->getFieldValue('field_data_field_miembro_de_junta_directiva', 'field_miembro_de_junta_directiva_value', 'user', $uid)
    );

    // field_portrabajos_cient_ficos_de
    $row->setSourceProperty(
      'field_portrabajos_cient_ficos_de',
      $this->getFieldValue('field_data_field_portrabajos_cient_ficos_de', 'field_portrabajos_cient_ficos_de_value', 'user', $uid)
    );

    // field_fecha_pago_afiliacion
    $row->setSourceProperty(
      'field_fecha_pago_afiliacion',
      $this->getFieldValue('field_data_field_fecha_pago_afiliacion', 'field_fecha_pago_afiliacion_value', 'user', $uid)
    );

    // field_fecha_vence_afiliacion
    $row->setSourceProperty(
      'field_fecha_vence_afiliacion',
      $this->getFieldValue('field_data_field_fecha_vence_afiliacion', 'field_fecha_vence_afiliacion_value', 'user', $uid)
    );

    // field_direccion_consultorio
    $row->setSourceProperty(
      'field_direccion_consultorio',
      $this->getFieldValue('field_data_field_direccion_consultorio', 'field_direccion_consultorio_value', 'user', $uid)
    );

    // field_cursos_y_diplomados_ayuda_
    $row->setSourceProperty(
      'field_cursos_y_diplomados_ayuda_',
      $this->getFieldValue('field_data_field_cursos_y_diplomados_ayuda_', 'field_cursos_y_diplomados_ayuda__value', 'user', $uid)
    );

    // field_publicaciones_en_libros_de
    $row->setSourceProperty(
      'field_publicaciones_en_libros_de',
      $this->getFieldValue('field_data_field_publicaciones_en_libros_de', 'field_publicaciones_en_libros_de_value', 'user', $uid)
    );

    // field_publicaciones_en_revistas_
    $row->setSourceProperty(
      'field_publicaciones_en_revistas_',
      $this->getFieldValue('field_data_field_publicaciones_en_revistas_', 'field_publicaciones_en_revistas__value', 'user', $uid)
    );

    // field_publicaciones_en_la_web_ay
    $row->setSourceProperty(
      'field_publicaciones_en_la_web_ay',
      $this->getFieldValue('field_data_field_publicaciones_en_la_web_ay', 'field_publicaciones_en_la_web_ay_value', 'user', $uid)
    );

    // field_actividad_como_docente_ayu
    $row->setSourceProperty(
      'field_actividad_como_docente_ayu',
      $this->getFieldValue('field_data_field_actividad_como_docente_ayu', 'field_actividad_como_docente_ayu_value', 'user', $uid)
    );

    // field_maestr_as_o_doctorados_ayu
    $row->setSourceProperty(
      'field_maestr_as_o_doctorados_ayu',
      $this->getFieldValue('field_data_field_maestr_as_o_doctorados_ayu', 'field_maestr_as_o_doctorados_ayu_value', 'user', $uid)
    );

    // field_premios_y_distinciones_ayu
    $row->setSourceProperty(
      'field_premios_y_distinciones_ayu',
      $this->getFieldValue('field_data_field_premios_y_distinciones_ayu', 'field_premios_y_distinciones_ayu_value', 'user', $uid)
    );

    // field_otras_actividades_no_inclu
    $row->setSourceProperty(
      'field_otras_actividades_no_inclu',
      $this->getFieldValue('field_data_field_otras_actividades_no_inclu', 'field_otras_actividades_no_inclu_value', 'user', $uid)
    );

    // url_alias
    $row->setSourceProperty(
      'url_alias',
      $this->getAlias("user/$uid")
    );

    return parent::prepareRow($row);
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return array(
      'uid' => array(
        'type' => 'integer',
        'alias' => 'u',
      ),
    );
  }

  /**
   * Returns the user base fields to be migrated.
   *
   * @return array
   *   Associative array having field name as key and description as value.
   */
  protected function baseFields() {
    $fields = array(
      'uid' => $this->t('User ID'),
      'name' => $this->t('Username'),
      'pass' => $this->t('Password'),
      'mail' => $this->t('Email address'),
      'signature' => $this->t('Signature'),
      'signature_format' => $this->t('Signature format'),
      'created' => $this->t('Registered timestamp'),
      'access' => $this->t('Last access timestamp'),
      'login' => $this->t('Last login timestamp'),
      'status' => $this->t('Status'),
      'timezone' => $this->t('Timezone'),
      // 'language' => $this->t('Language'),
      'picture' => $this->t('Picture'),
      'init' => $this->t('Init'),
    );

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function bundleMigrationRequired() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function entityTypeId() {
    return 'user';
  }

}
