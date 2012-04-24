Joomla v.1.5+ Skroutz Easy module
====================================

## English

### Requirements

 - [Joomla! v.1.5 or v.2.5](http://www.joomla.org)
 - [VirtueMart 2.0.2](http://virtuemart.net)

### Installation instructions

1. Install Joomla! and VirtueMart
2. ...
3. Add DB fields for VirtueMart:
    - Components -> VirtueMart
    - Configuration -> Shopper Fields -> New (x2)
        - Field name: vm_tin
        - Field title: Taxpayer Identification Number
        - Max Lenght: 10
        - Field size: 32

        - Field name: vm_irc_office
        - Field title: Local IRS office
        - Field size: 64

        - vm_afm
        - vm_doy

4. Login to the 'Administration Tool' and enable the 'Extension'
    - Select 'Install / Uninstall' from the 'Extensions' menu
    - Click 'Choose file' and select the extension from your HDD
    - Upload the file using 'Upload File & Install'
    - ...

5. Add the keys you obtained from Skroutz:
    - Select 'Skroutz Easy' from the 'Components' menu
    - ... client_id
    - ... client_secret

## Greek

### Απαιτήσεις

 - [Joomla! v.1.5 or v.2.5](http://www.joomla.org)
 - [VirtueMart 2.0.2](http://virtuemart.net)

### Οδηγίες εγκατάστασης

...
