<?php

namespace Proxies\__CG__\App\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Partenaire extends \App\Entity\Partenaire implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'id', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'ninea', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'raisonSociale', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'nomComplet', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'telephone', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'email', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'adresse', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'partenaire', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'statut', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'users'];
        }

        return ['__isInitialized__', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'id', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'ninea', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'raisonSociale', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'nomComplet', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'telephone', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'email', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'adresse', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'partenaire', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'statut', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'users'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Partenaire $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getNinea(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNinea', []);

        return parent::getNinea();
    }

    /**
     * {@inheritDoc}
     */
    public function setNinea(string $ninea): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNinea', [$ninea]);

        return parent::setNinea($ninea);
    }

    /**
     * {@inheritDoc}
     */
    public function getRaisonSociale(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRaisonSociale', []);

        return parent::getRaisonSociale();
    }

    /**
     * {@inheritDoc}
     */
    public function setRaisonSociale(string $raisonSociale): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRaisonSociale', [$raisonSociale]);

        return parent::setRaisonSociale($raisonSociale);
    }

    /**
     * {@inheritDoc}
     */
    public function getNomComplet(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNomComplet', []);

        return parent::getNomComplet();
    }

    /**
     * {@inheritDoc}
     */
    public function setNomComplet(string $nomComplet): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNomComplet', [$nomComplet]);

        return parent::setNomComplet($nomComplet);
    }

    /**
     * {@inheritDoc}
     */
    public function getTelephone(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTelephone', []);

        return parent::getTelephone();
    }

    /**
     * {@inheritDoc}
     */
    public function setTelephone(string $telephone): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTelephone', [$telephone]);

        return parent::setTelephone($telephone);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmail(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmail', []);

        return parent::getEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function setEmail(string $email): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEmail', [$email]);

        return parent::setEmail($email);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdresse(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAdresse', []);

        return parent::getAdresse();
    }

    /**
     * {@inheritDoc}
     */
    public function setAdresse(string $adresse): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAdresse', [$adresse]);

        return parent::setAdresse($adresse);
    }

    /**
     * {@inheritDoc}
     */
    public function getPartenaire(): \Doctrine\Common\Collections\Collection
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPartenaire', []);

        return parent::getPartenaire();
    }

    /**
     * {@inheritDoc}
     */
    public function addPartenaire(\App\Entity\Compte $partenaire): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPartenaire', [$partenaire]);

        return parent::addPartenaire($partenaire);
    }

    /**
     * {@inheritDoc}
     */
    public function removePartenaire(\App\Entity\Compte $partenaire): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removePartenaire', [$partenaire]);

        return parent::removePartenaire($partenaire);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatut(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatut', []);

        return parent::getStatut();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatut(string $statut): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatut', [$statut]);

        return parent::setStatut($statut);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers(): \Doctrine\Common\Collections\Collection
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsers', []);

        return parent::getUsers();
    }

    /**
     * {@inheritDoc}
     */
    public function addUser(\App\Entity\User $user): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addUser', [$user]);

        return parent::addUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function removeUser(\App\Entity\User $user): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeUser', [$user]);

        return parent::removeUser($user);
    }

}
