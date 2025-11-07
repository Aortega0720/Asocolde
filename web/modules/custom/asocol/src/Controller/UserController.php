<?php

namespace Drupal\asocol\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller routines for user routes.
 */
class UserController extends ControllerBase {

  public function userLogin(Request $request) {
    $form = \Drupal::formBuilder()->getForm('Drupal\user\Form\UserLoginForm');
    if($request->query->get('_wrapper_format') == 'drupal_modal') {
      $build['content'] = [
        '#theme' => 'asocol_modal_login',
        '#form' => $form,
      ];
    }
    else {
      $build = $form;
    }

    return $build;
  }

  public function userMembershipPage() {
    $account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $status = 'No verificado';
    if(!$account->field_membership->isEmpty()) {
      $status = $account->field_membership->value ? 'Activo' : 'Inactivo';
    }
    $build = [
      '#theme' => 'membership_page',
      '#status' => $status,
      '#list' => [
        '#type' => 'view',
        '#name' => 'membership_payment',
        '#display_id' => 'block',
        '#embed' => TRUE,
      ],
    ];

    return $build;
  }

  public function userCertificationPage() {
    $account = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $points_scientific = $account->field_points_scientific->getString();
    $points_congress = $account->field_points_congress->getString();
    $points_work = $account->field_points_work->getString();
    $build = [
      '#theme' => 'certification_page',
      '#items' => [
        [
          'title' => 'Actividad Societaria',
          'field_name' => 'Puntos por pertenecer a una asociación científica (AsoColDerma)',
          'points' => $points_scientific,
        ],
        [
          'title' => 'Actividad Científica y otras',
          'field_name' => 'Congresos Nacionales e Internacionales, publicaciones, actividades docentes, maestrías/doctorados, otras',
          'points' => $points_congress,
        ],
        [
          'title' => 'Actividad Laboral',
          'field_name' => 'En su consultorio particular o bajo contrato con entidades prestadoras de salud',
          'points' => $points_work,
        ],
      ],
      '#points' => $points_scientific + $points_congress + $points_work,
    ];

    return $build;
  }

  public function userEditPublicPage() {
    return $this->buildForm('public');
  }

  public function userEditServicesPage() {
    $form = $this->buildForm('services');
    $form['field_services_specialties']['widget']['#title'] = 'Presta usted los siguientes Servicios en su consulta:';
    return $form;
  }

  public function userEditPrivatePage() {
    return $this->buildForm('private');
  }

  public function userEditConfigurationPage() {
    $form = $this->buildForm('configuration');
    $form['field_recertificate']['widget']['value']['#title'] = 'Deseo participar en el programa de Re-certificación interno';
    $form['field_profile_directory']['widget']['value']['#title'] = 'Mostrar mi perfil a los pacientes en el Directorio';
    return $form;
  }

  private function buildForm($formDisplayName) {
    $entity =  $this->entityTypeManager()->getStorage('user')->load($this->currentUser()->id());
    return \Drupal::service('entity.form_builder')->getForm($entity, $formDisplayName);
  }

}
