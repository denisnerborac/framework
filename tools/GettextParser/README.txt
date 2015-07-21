ibis-IT gettext_smarty

Utility for extracting the content between block quotes from Smarty templates and writing them into .po files for the purpose of translation.

Dependencies:
Microsoft .NET 4 Client Profile
Get it here:
http://www.microsoft.com/en-us/download/details.aspx?id=24872

You may use the program freely.

You may not redistribute the programm.

Limitation of Liabilities:
In no event shall ibis-IT, Jens Kaufmann be liable to you or any party related to you for any indirect, incidental, consequential, special, exemplary, or punitive damages or lost profits, even if ibis-IT, Jens Kaufmann has been advised of the possibility of such damages.

In any event, ibis-IT, Jens Kaufmann' total aggregate liability to you for all damages of every kind and type (regardless of whether based in contract or tort) shall not exceed the purchase price of the product.


ibis-IT
Jens Kaufmann
Thiestr. 8
38277 Heere
Germany

E-Mail: kaufmann@ibis-it.de


Usage:
gettext_smarty -o OUTPUT_FILE -k"{KEYWORD}".. INPUT_FILE..
Scans the given Smarty Template input files for occurences of defined block quotes with the given keywords.

You may provide multiple keywords as well as multiple input files.

Example:
 gettext_smarty -o out.po -k"{t}" template.tpl

 This will scan the template.tpl template for block quotes like {t}translate me{/t} and will extract
 "translate me" for translation.