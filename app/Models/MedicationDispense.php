<?php

namespace App\Models;

use App\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MedicationDispense extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(function ($medicationDispense) {
            $orgId = config('organization_id');

            $identifier = new MedicationDispenseIdentifier();
            $identifier->system = 'http://sys-ids.kemkes.go.id/medicationdispense/' . $orgId;
            $identifier->use = 'official';
            $identifier->value = $medicationDispense->identifier()->max('value') + 1;

            // Save the identifier through the relationship
            $medicationDispense->identifier()->save($identifier);
        });
    }

    public const STATUS_SYSTEM = 'http://terminology.hl7.org/CodeSystem/medicationdispense-status';
    public const STATUS_CODE = ['preparation', 'in-progress', 'cancelled', 'on-hold', 'completed', 'entered-in-error', 'stopped', 'declined', 'unknown'];
    public const STATUS_DISPLAY = ["preparation" => "Persiapan", "in-progress" => "Dalam proses", "cancelled" => "Dibatalkan", "on-hold" => "Tertahan", "completed" => "Lengkap", "entered-in-error" => "Salah", "stopped" => "Dihentikan", "declined" => "Ditolak", "unknown" => "Tidak diketahui"];

    public const CATEGORY_SYSTEM = 'http://terminology.hl7.org/fhir/CodeSystem/medicationdispense-category';
    public const CATEGORY_CODE = ['inpatient', 'outpatient', 'community', 'discharge'];
    public const CATEGORY_DISPLAY = ["inpatient" => "Inpatient", "outpatient" => "Outpatient", "community" => "Community", "discharge" => "Discharge"];
    public const CATEGORY_DEFINITION = ["inpatient" => "Pemberian obat untuk diadministrasikan atau dikonsumsi saat rawat inap", "outpatient" => "Pemberian obat untuk diadministrasikan atau dikonsumsi saat rawat jalan (cth. IGD, poliklinik rawat jalan, bedah rawat jalan, dll)", "community" => "Pemberian obat untuk diadministrasikan atau dikonsumsi di rumah (long term care atau nursing home, atau hospices)", "discharge" => "Pemberian obat yang dibuat ketika pasien dipulangkan dari fasilitas kesehatan"];

    public const QUANTITY_SYSTEM = ['_AdministrableDrugForm' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'APPFUL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'DROP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'NDROP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OPDROP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ORDROP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OTDROP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'PUFF' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SCOOP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SPRY' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '_DispensableDrugForm' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '_GasDrugForm' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'GASINHL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '_GasLiquidMixture' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'AER' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'BAINHL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'INHLSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'MDINHL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'NASSPRY' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'DERMSPRY' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'FOAM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'FOAMAPL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RECFORM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGFOAM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGFOAMAPL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RECSPRY' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGSPRY' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '_GasSolidSpray' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'INHL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'BAINHLPWD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'INHLPWD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'MDINHLPWD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'NASINHL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ORINHL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'PWDSPRY' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SPRYADAPT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '_Liquid' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'LIQCLN' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'LIQSOAP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SHMP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OIL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TOPOIL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'IPSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'IRSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'DOUCHE' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ENEMA' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OPIRSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'IVSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ORALSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ELIXIR' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RINSE' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SYRUP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RECSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TOPSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'LIN' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'MUCTOPSOL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TINC' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '_LiquidLiquidEmulsion' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CRM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'NASCRM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OPCRM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ORCRM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OTCRM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RECCRM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TOPCRM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGCRM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGCRMAPL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'LTN' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TOPLTN' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OINT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'NASOINT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OINTAPL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OPOINT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OTOINT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RECOINT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TOPOINT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGOINT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGOINTAPL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '_LiquidSolidSuspension' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'GEL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'GELAPL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'NASGEL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OPGEL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OTGEL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TOPGEL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'URETHGEL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGGEL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VGELAPL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'PASTE' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'PUD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TPASTE' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SUSP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ITSUSP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OPSUSP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ORSUSP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERSUSP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERSUSP12' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERSUSP24' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'OTSUSP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RECSUSP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '_SolidDrugForm' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'BAR' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'BARSOAP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'MEDBAR' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CHEWBAR' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'BEAD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CAKE' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CEMENT' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CRYS' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'DISK' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'FLAKE' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'GRAN' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'GUM' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'PAD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'MEDPAD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'PATCH' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TPATCH' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TPATH16' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TPATH24' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TPATH2WK' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TPATH72' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TPATHWK' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'PELLET' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'PILL' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CAP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ORCAP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ENTCAP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERENTCAP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERCAP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERCAP12' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERCAP24' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERECCAP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ORTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'BUCTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SRBUCTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CAPLET' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CHEWTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'CPTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'DISINTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'DRTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ECTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERECTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERTAB12' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ERTAB24' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'ORTROCHE' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SLTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGTAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'POWD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'TOPPWD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RECPWD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGPWD' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SUPP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'RECSUPP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'URETHSUPP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'VAGSUPP' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'SWAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'MEDSWAB' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', 'WAFER' => 'http://terminology.hl7.org/CodeSystem/v3-orderableDrugForm', '738998008' => 'http://snomed.info/sct', '763824009' => 'http://snomed.info/sct', '442015005' => 'http://snomed.info/sct', '385286003' => 'http://snomed.info/sct', '385174007' => 'http://snomed.info/sct', '764296002' => 'http://snomed.info/sct', '761877007' => 'http://snomed.info/sct', '421366001' => 'http://snomed.info/sct', '421701006' => 'http://snomed.info/sct', '385057009' => 'http://snomed.info/sct', '385120001' => 'http://snomed.info/sct', '764772008' => 'http://snomed.info/sct', '385292009' => 'http://snomed.info/sct'];
    public const QUANTITY_CODE = ['_AdministrableDrugForm', 'APPFUL', 'DROP', 'NDROP', 'OPDROP', 'ORDROP', 'OTDROP', 'PUFF', 'SCOOP', 'SPRY', '_DispensableDrugForm', '_GasDrugForm', 'GASINHL', '_GasLiquidMixture', 'AER', 'BAINHL', 'INHLSOL', 'MDINHL', 'NASSPRY', 'DERMSPRY', 'FOAM', 'FOAMAPL', 'RECFORM', 'VAGFOAM', 'VAGFOAMAPL', 'RECSPRY', 'VAGSPRY', '_GasSolidSpray', 'INHL', 'BAINHLPWD', 'INHLPWD', 'MDINHLPWD', 'NASINHL', 'ORINHL', 'PWDSPRY', 'SPRYADAPT', '_Liquid', 'LIQCLN', 'LIQSOAP', 'SHMP', 'OIL', 'TOPOIL', 'SOL', 'IPSOL', 'IRSOL', 'DOUCHE', 'ENEMA', 'OPIRSOL', 'IVSOL', 'ORALSOL', 'ELIXIR', 'RINSE', 'SYRUP', 'ORDROP', 'RECSOL', 'TOPSOL', 'LIN', 'MUCTOPSOL', 'TINC', 'DROP', '_LiquidLiquidEmulsion', 'CRM', 'NASCRM', 'OPCRM', 'ORCRM', 'OTCRM', 'RECCRM', 'TOPCRM', 'VAGCRM', 'VAGCRMAPL', 'LTN', 'TOPLTN', 'OINT', 'NASOINT', 'OINTAPL', 'OPOINT', 'OTOINT', 'RECOINT', 'TOPOINT', 'VAGOINT', 'VAGOINTAPL', '_LiquidSolidSuspension', 'GEL', 'GELAPL', 'NASGEL', 'OPGEL', 'OTGEL', 'TOPGEL', 'URETHGEL', 'VAGGEL', 'VGELAPL', 'PASTE', 'PUD', 'TPASTE', 'SUSP', 'ITSUSP', 'OPSUSP', 'ORSUSP', 'ERSUSP', 'ERSUSP12', 'ERSUSP24', 'OTSUSP', 'RECSUSP', '_SolidDrugForm', 'BAR', 'BARSOAP', 'MEDBAR', 'CHEWBAR', 'BEAD', 'CAKE', 'CEMENT', 'CRYS', 'DISK', 'FLAKE', 'GRAN', 'GUM', 'PAD', 'MEDPAD', 'PATCH', 'TPATCH', 'TPATH16', 'TPATH24', 'TPATH2WK', 'TPATH72', 'TPATHWK', 'PELLET', 'PILL', 'CAP', 'ORCAP', 'ENTCAP', 'ERENTCAP', 'ERCAP', 'ERCAP12', 'ERCAP24', 'ERECCAP', 'ERENTCAP', 'TAB', 'ORTAB', 'BUCTAB', 'SRBUCTAB', 'CAPLET', 'CHEWTAB', 'CPTAB', 'DISINTAB', 'DRTAB', 'ECTAB', 'ERECTAB', 'ERTAB', 'ERTAB12', 'ERTAB24', 'ERECTAB', 'ORTROCHE', 'SLTAB', 'VAGTAB', 'POWD', 'TOPPWD', 'RECPWD', 'VAGPWD', 'SUPP', 'RECSUPP', 'URETHSUPP', 'VAGSUPP', 'SWAB', 'MEDSWAB', 'WAFER', '738998008', '763824009', '442015005', '385286003', '385174007', '764296002', '761877007', '421366001', '421701006', '385057009', '385120001', '764772008', '385292009'];
    public const QUANTITY_DISPLAY = ["_AdministrableDrugForm" => "AdministrableDrugForm", "APPFUL" => "Applicatorful", "DROP" => "Drops", "NDROP" => "Nasal Drops", "OPDROP" => "Ophthalmic Drops", "ORDROP" => "Oral Drops", "OTDROP" => "Otic Drops", "PUFF" => "Puff", "SCOOP" => "Scoops", "SPRY" => "Sprays", "_DispensableDrugForm" => "DispensableDrugForm", "_GasDrugForm" => "GasDrugForm", "GASINHL" => "Gas for Inhalation", "_GasLiquidMixture" => "GasLiquidMixture", "AER" => "Aerosol", "BAINHL" => "Breath Activated Inhaler", "INHLSOL" => "Inhalant Solution", "MDINHL" => "Metered Dose Inhaler", "NASSPRY" => "Nasal Spray", "DERMSPRY" => "Dermal Spray", "FOAM" => "Foam", "FOAMAPL" => "Foam with Applicator", "RECFORM" => "Rectal foam", "VAGFOAM" => "Vaginal foam", "VAGFOAMAPL" => "Vaginal foam with applicator", "RECSPRY" => "Rectal Spray", "VAGSPRY" => "Vaginal Spray", "_GasSolidSpray" => "GasSolidSpray", "INHL" => "Inhalant", "BAINHLPWD" => "Breath Activated Powder Inhaler", "INHLPWD" => "Inhalant Powder", "MDINHLPWD" => "Metered Dose Powder Inhaler", "NASINHL" => "Nasal Inhalant", "ORINHL" => "Oral Inhalant", "PWDSPRY" => "Powder Spray", "SPRYADAPT" => "Spray with Adaptor", "_Liquid" => "Liquid", "LIQCLN" => "Liquid Cleanser", "LIQSOAP" => "Medicated Liquid Soap", "SHMP" => "Shampoo", "OIL" => "Oil", "TOPOIL" => "Topical Oil", "SOL" => "Solution", "IPSOL" => "Intraperitoneal Solution", "IRSOL" => "Irrigation Solution", "DOUCHE" => "Douche", "ENEMA" => "Enema", "OPIRSOL" => "Ophthalmic Irrigation Solution", "IVSOL" => "Intravenous Solution", "ORALSOL" => "Oral Solution", "ELIXIR" => "Elixir", "RINSE" => "Mouthwash/Rinse", "SYRUP" => "Syrup", "RECSOL" => "Rectal Solution", "TOPSOL" => "Topical Solution", "LIN" => "Liniment", "MUCTOPSOL" => "Mucous Membrane Topical Solution", "TINC" => "Tincture", "_LiquidLiquidEmulsion" => "LiquidLiquidEmulsion", "CRM" => "Cream", "NASCRM" => "Nasal Cream", "OPCRM" => "Ophthalmic Cream", "ORCRM" => "Oral Cream", "OTCRM" => "Otic Cream", "RECCRM" => "Rectal Cream", "TOPCRM" => "Topical Cream", "VAGCRM" => "Vaginal Cream", "VAGCRMAPL" => "Vaginal Cream with Applicator", "LTN" => "Lotion", "TOPLTN" => "Topical Lotion", "OINT" => "Ointment", "NASOINT" => "Nasal Ointment", "OINTAPL" => "Ointment with Applicator", "OPOINT" => "Ophthalmic Ointment", "OTOINT" => "Otic Ointment", "RECOINT" => "Rectal Ointment", "TOPOINT" => "Topical Ointment", "VAGOINT" => "Vaginal Ointment", "VAGOINTAPL" => "Vaginal Ointment with Applicator", "_LiquidSolidSuspension" => "LiquidSolidSuspension", "GEL" => "Gel", "GELAPL" => "Gel with Applicator", "NASGEL" => "Nasal Gel", "OPGEL" => "Ophthalmic Gel", "OTGEL" => "Otic Gel", "TOPGEL" => "Topical Gel", "URETHGEL" => "Urethral Gel", "VAGGEL" => "Vaginal Gel", "VGELAPL" => "Vaginal Gel with Applicator", "PASTE" => "Paste", "PUD" => "Pudding", "TPASTE" => "Toothpaste", "SUSP" => "Suspension", "ITSUSP" => "Intrathecal Suspension", "OPSUSP" => "Ophthalmic Suspension", "ORSUSP" => "Oral Suspension", "ERSUSP" => "Extended-Release Suspension", "ERSUSP12" => "12 Hour Extended-Release Suspension", "ERSUSP24" => "24 Hour Extended Release Suspension", "OTSUSP" => "Otic Suspension", "RECSUSP" => "Rectal Suspension", "_SolidDrugForm" => "SolidDrugForm", "BAR" => "Bar", "BARSOAP" => "Bar Soap", "MEDBAR" => "Medicated Bar Soap", "CHEWBAR" => "Chewable Bar", "BEAD" => "Beads", "CAKE" => "Cake", "CEMENT" => "Cement", "CRYS" => "Crystals", "DISK" => "Disk", "FLAKE" => "Flakes", "GRAN" => "Granules", "GUM" => "ChewingGum", "PAD" => "Pad", "MEDPAD" => "Medicated Pad", "PATCH" => "Patch", "TPATCH" => "Transdermal Patch", "TPATH16" => "16 Hour Transdermal Patch", "TPATH24" => "24 Hour Transdermal Patch", "TPATH2WK" => "Biweekly Transdermal Patch", "TPATH72" => "72 Hour Transdermal Patch", "TPATHWK" => "Weekly Transdermal Patch", "PELLET" => "Pellet", "PILL" => "Pill", "CAP" => "Capsule", "ORCAP" => "Oral Capsule", "ENTCAP" => "Enteric Coated Capsule", "ERENTCAP" => "Extended Release Enteric Coated Capsule", "ERCAP" => "Extended Release Capsule", "ERCAP12" => "12 Hour Extended Release Capsule", "ERCAP24" => "24 Hour Extended Release Capsule", "ERECCAP" => "Extended Release Enteric Coated Capsule", "TAB" => "Tablet", "ORTAB" => "Oral Tablet", "BUCTAB" => "Buccal Tablet", "SRBUCTAB" => "Sustained Release Buccal Tablet", "CAPLET" => "Caplet", "CHEWTAB" => "Chewable Tablet", "CPTAB" => "Coated Particles Tablet", "DISINTAB" => "Disintegrating Tablet", "DRTAB" => "Delayed Release Tablet", "ECTAB" => "Enteric Coated Tablet", "ERECTAB" => "Extended Release Enteric Coated Tablet", "ERTAB" => "Extended Release Tablet", "ERTAB12" => "12 Hour Extended Release Tablet", "ERTAB24" => "24 Hour Extended Release Tablet", "ORTROCHE" => "Lozenge/Oral Troche", "SLTAB" => "Sublingual Tablet", "VAGTAB" => "Vaginal Tablet", "POWD" => "Powder", "TOPPWD" => "Topical Powder", "RECPWD" => "Rectal Powder", "VAGPWD" => "Vaginal Powder", "SUPP" => "Suppository", "RECSUPP" => "Rectal Suppository", "URETHSUPP" => "Urethral suppository", "VAGSUPP" => "Vaginal Suppository", "SWAB" => "Swab", "MEDSWAB" => "Medicated swab", "WAFER" => "Wafer", "738998008" => "Emulsion", "763824009" => "Gas", "442015005" => "Intrauterine dose form", "385286003" => "Implant", "385174007" => "Pessary", "764296002" => "Prolonged-release", "761877007" => "Effervescent tablet", "421366001" => "Tablet for oral suspension", "421701006" => "Tablet for conventional release oral solution", "385057009" => "Film-coated tablet", "385120001" => "Impregnated dressing", "764772008" => "Prolonged-release vaginal ring", "385292009" => "Vaginal dose form"];

    protected $table = 'medication_dispense';
    protected $casts = [
        'quantity_value' => 'decimal:2',
        'days_supply_value' => 'decimal:2',
        'when_prepared' => 'datetime',
        'when_handed_over' => 'datetime'
    ];
    public $timestamps = false;
    protected $with = ['identifier', 'partOf', 'performer', 'authorizingPrescription', 'dosage', 'substitution'];

    public function resource(): BelongsTo
    {
        return $this->belongsTo(Resource::class);
    }

    public function identifier(): HasMany
    {
        return $this->hasMany(MedicationDispenseIdentifier::class, 'dispense_id');
    }

    public function partOf(): HasMany
    {
        return $this->hasMany(MedicationDispensePartOf::class, 'dispense_id');
    }

    public function performer(): HasMany
    {
        return $this->hasMany(MedicationDispensePerformer::class, 'dispense_id');
    }

    public function authorizingPrescription(): HasMany
    {
        return $this->hasMany(MedicationDispenseAuthorizingPrescription::class, 'dispense_id');
    }

    public function dosage(): HasMany
    {
        return $this->hasMany(MedicationDispenseDosageInstruction::class, 'dispense_id');
    }

    public function substitution(): HasOne
    {
        return $this->hasOne(MedicationDispenseSubstitution::class, 'dispense_id');
    }
}
