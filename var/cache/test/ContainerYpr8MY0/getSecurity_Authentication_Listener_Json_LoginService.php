<?php

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.
// Returns the private 'security.authentication.listener.json.login' shared service.

include_once $this->targetDirs[3].'/vendor/symfony/security-http/Firewall/ListenerInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/Firewall/LegacyListenerTrait.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/Firewall/UsernamePasswordJsonAuthenticationListener.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/Session/SessionAuthenticationStrategyInterface.php';
include_once $this->targetDirs[3].'/vendor/symfony/security-http/Session/SessionAuthenticationStrategy.php';

$this->privates['security.authentication.listener.json.login'] = $instance = new \Symfony\Component\Security\Http\Firewall\UsernamePasswordJsonAuthenticationListener(($this->services['security.token_storage'] ?? ($this->services['security.token_storage'] = new \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage())), ($this->privates['security.authentication.manager'] ?? $this->getSecurity_Authentication_ManagerService()), ($this->privates['security.http_utils'] ?? $this->load('getSecurity_HttpUtilsService.php')), 'login', ($this->privates['security.authentication.success_handler.login.json_login'] ?? $this->load('getSecurity_Authentication_SuccessHandler_Login_JsonLoginService.php')), ($this->privates['security.authentication.failure_handler.login.json_login'] ?? $this->load('getSecurity_Authentication_FailureHandler_Login_JsonLoginService.php')), ['check_path' => '/api/login', 'use_forward' => false, 'require_previous_session' => false, 'username_path' => 'username', 'password_path' => 'password'], ($this->privates['logger'] ?? ($this->privates['logger'] = new \Symfony\Component\HttpKernel\Log\Logger())), ($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), ($this->services['easyadmin.property_accessor'] ?? $this->getEasyadmin_PropertyAccessorService()));

$instance->setSessionAuthenticationStrategy(($this->privates['security.authentication.session_strategy_noop'] ?? ($this->privates['security.authentication.session_strategy_noop'] = new \Symfony\Component\Security\Http\Session\SessionAuthenticationStrategy('none'))));

return $instance;
