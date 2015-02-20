=============================
Uniform Entity Resource (UER)
=============================

The purpose of this project is to create a simple framework whereby various "RI"
(Resource Identifiers) can be converted into objects. The assumption is that all
RI indicate their schema followed by a colon.   This holds true of HTTP URLs and 
URNs and all other user cases examined before I started work.

SRI
---
[System Resource Identifiers] follow the exact same pattern as URNs but they are 
intended for use internally.  They form as SRU:NID:SSI and thus cannot cause any
namespace clashes with actual URNs.

If you do not like this idea feel free to simply ignore it.

EO and sysEO
------------
The EO folder contains project "Entity Objects" and is intended for RIs external 
to the system. Whereas sysEO was intended for objects that are bound to the host
system. sysEO can and should be moved to whatever folder makes internal sense in
the project the UER system is part of.   The location can be set by defining the 
constant _SYS_EO_PATH_ before EntityProcess.php is included. It should be a path
that does _not_ contain a trailing slash.

These folders, (along with 'a' for abstract & 'i' for interface),  are inspected
by the private autoloader.  So the names need only be listed to EnitityProcessor
for the classes to be put to work.

iEntityClass
------------
This interface enforces two static and two "regular" methods.  As Processing and 
Handling of RIs is dynamic based on schema such methods can not be enforced.  At
least not in the same way.

Default Classes
---------------
UER recognises two default classes that act as a general catch all for unhandled
URLs, URNs & SRNs. These are, (at present), baked in to the design and cannot be 
removed. I am aware that this is not great and will address it given time.

The defaultURL class has a public variable $infoURL which unhandled URNs will be
attached as a suffix.   This can be changed before rendering.  Rendering is very
basic as is the class itself.  Ideally it could be extended to fetch headers and
examine oGraph data etc..