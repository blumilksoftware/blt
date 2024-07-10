<?php

declare(strict_types=1);

namespace Blumilk\BLT\Features\Traits;

use Behat\Gherkin\Node\TableNode;
use Blumilk\BLT\Features\Traits\Optional\SpatiePermission;
use Symfony\Component\HttpFoundation\Response;

trait CodeBlocks
{
    use Eloquent;
    use SpatiePermission;
    use Authentication;
    use Http;

    /**
     * @Given user is in session as admin
     * @Given user in session has role :role
     */
    public function sessionHasUserWithRole(string $role = "admin"): void
    {
        $roleArray = [
            ["name", $role],
        ];
        $roleTable = new TableNode($roleArray);
        $this->seedModelInTheDatabase("Role", $roleTable);
        $userArray = [
            ["name", $role],
            ["email", "userWithRole@example.com"],
            ["password", "password123!@#"],
        ];
        $userTable = new TableNode($userArray);
        $this->seedModelInTheDatabase("User", $userTable);

        $this->assignRoleTo($role, "User", "userWithRole@example.com", "email");

        $this->userIsAuthenticatedInSessionAs($role, "name");
    }

    /**
     * @Given admin user is getting OK response from :url
     * @Given admin user is getting :status status code response from :url
     * @Given user with :role role is getting OK response from :url
     * @Given user with :role role is getting :status response from :url
     * @Given user with :role role is getting OK response from :url using :method method
     * @Given user with :role role is getting :status response from :url using :method method
     */
    public function adminUserIsGettingResponse(string $url, string $method = "GET", int $status = Response::HTTP_OK, string $role = "admin"): void
    {
        $this->sessionHasUserWithRole($role);
        $this->aUserIsRequesting($url, $method);
        $this->aRequestIsSent();
        $this->aResponseShouldHaveStatus($status);
    }
}
