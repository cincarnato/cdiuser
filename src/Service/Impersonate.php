<?php

namespace CdiUser\Service;

use ZfcUser\Service\User as ZfcUserUserService;


class Impersonate extends ZfcUserUserService
{


    /**
     * @var \ZfcUser\Options\UserServiceOptionsInterface
     */
    protected $cdiUserOptions;

    /**
     * The storage container in which the 'impersonator' (real user) is stored whilst they are impersonating another
     * user.
     *
     * @var \Zend\Authentication\Storage\StorageInterface
     */
    protected $storageForImpersonator;

    /**
     * Store the user as an object (true) or id (false)
     *
     * @var bool
     */
    protected $storeUserAsObject;

    /**
     * Begin impersonation of the user identified by the supplied user id.
     *
     * The specified user becomes the current user, such that for all intents and purposes they are now the logged-in
     * user. The 'impersonator' (real user) can be restored, and impersonation ended, by calling unimpersonate().
     *
     * @param string $userId
     */
    public function impersonate($userId)
    {
        // Ensure that there is a current user (i.e. the user is logged in).
        if (!($this->getAuthService()->getIdentity() instanceof UserInterface)) {
            throw new UserNotLoggedInException();
        }

        // Retrieve the user to impersonate.
        $userToImpersonate = $this->getUserMapper()->findById($userId);

        // Assert that the user to impersonate is valid.
        if (!$userToImpersonate instanceof UserInterface) {
            // User not found.
            throw new UserNotFoundException();
        }

        // Store the 'impersonator' (real user) in storage to allow later unimpersonation.
        $this->getStorageForImpersonator()->write($this->getAuthService()->getIdentity());

        // Config setting determines whether to write the whole object to the session
        // or just the ID
        if (!$this->getStoreUserAsObject()) {
            $userToImpersonate = $userToImpersonate->getId();
        }

        // Start impersonation by overwriting the identity stored in auth storage. Essentially, this sets the user to
        // impersonate as the logged-in user.
        $this->getAuthService()->getStorage()->write($userToImpersonate);
    }

    /**
     * End impersonation.
     *
     * The 'impersonator' (real user) becomes the current user once more, such that they are now the logged-in user.
     * The identity of the user that was impersonated is cleared, leaving them logged-out.
     */
    public function unimpersonate()
    {
        // Assert that impersonation is in progress (i.e. the current user is being impersonated).
        if (!$this->isImpersonated()) {
            throw new NotImpersonatingException();
        }

        // Retrieve the 'impersonator' (real user) from storage.
        $impersonatorUser = $this->getStorageForImpersonator()->read();

        // Assert that the 'impersonator' (real user) is valid.
        if (!$impersonatorUser instanceof UserInterface) {
            // The 'impersonator' (real user) is not the correct type.
            throw new DomainException(
                '$$impersonatorUser is not an instance of UserInterface',
                500
            );
        }

        // Config setting determines whether to write the whole object to the session
        // or just the ID
        if (!$this->getStoreUserAsObject()) {
            $impersonatorUser = $impersonatorUser->getId();
        }


        // End impersonation by restoring the original identity - the 'impersonator' (real user) - to auth storage.
        $this->getAuthService()->getStorage()->write($impersonatorUser);

        // Clear the 'impersonator' (real user) from storage.
        $this->getStorageForImpersonator()->clear();
    }

    /**
     * Return true if impersonation is in progress (i.e. the current user is being impersonated).
     *
     * @return boolean
     */
    public function isImpersonated()
    {
        // If the 'impersonator' (real user) storage is empty, the current user is not being impersonated.
        return !$this->getStorageForImpersonator()->isEmpty();
    }

    /**
     * Get the storage container for the 'impersonator' (real user).
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @return \Zend\Authentication\Storage\StorageInterface
     */
    public function getStorageForImpersonator()
    {
        return $this->storageForImpersonator;
    }

    /**
     * Set the storage container for the 'impersonator' (real user).
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @param  \Zend\Authentication\Storage\StorageInterface $storageForImpersonator
     * @return \ZfcUser\Service\User
     */
    public function setStorageForImpersonator(StorageInterface $storageForImpersonator)
    {
        // Set the storage container.
        $this->storageForImpersonator = $storageForImpersonator;

        // Fluent interface.
        return $this;
    }

    /**
     * Get the setting for storing user to the session as object (rather than ID)
     *
     * @return bool
     */
    public function getStoreUserAsObject()
    {
        return $this->storeUserAsObject;
    }

    /**
     * Set the setting for storing user to the session as object (rather than ID)
     *
     * @param bool $storeAsObject
     * @return \ZfcUser\Options\ModuleOptions
     */
    public function setStoreUserAsObject($storeAsObject)
    {
        $this->storeUserAsObject = $storeAsObject;

        // Fluent interface.
        return $this;
    }


}

