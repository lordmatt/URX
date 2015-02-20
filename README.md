# URX
An extensible library for handling Resource Identifiers in a web-generation context.

Handles URLs and URNs like a pro. It does not however really do anything with them as that is your job.

# Overview
Development Status: Mid Alpha

Functionality: Minimal

# Details
Specially engineered from the ground up to convert all forms of Resource Identifier into an object that can be made used of and optionally rendered in a uniform way. This is not designed to be especially useful outside of other projects which might make use of this feature as a core module.

See Uniform Entity Resource (EUR) readme file for details: https://github.com/lordmatt/URX/blob/master/UER/readme.txt

This project is a rewrite of UEntity which does the same thing and works but is, IMHO, not well written. I can make it available if anyone is really interested.

# Usage

1. Download and place the UER folder within your project.

2. Require files

        require_once("./UER/URX.php");

3. Make object

        $EP = new EntityProcessor();

4. Get your first URX object:

        $Object = $EP->getObject($MyString);

5. Make something wonderful. 

        (You are on your own with that one).