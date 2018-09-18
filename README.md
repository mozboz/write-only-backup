# write-only-backup

Quick and loose PHP to facilitate write only backup HTTP POST endpoint for simple write only backups of small amounts of stuff (upto 100Mb) from other servers.

To use from command line:

    curl -F 'backup=@/path/to/file' -F 'submit=submit' -F 'bucket=database' host.com/upload.php

