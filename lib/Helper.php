<?php

    class Helper
    {

        // Commonly used REGULAR EXPRESSSIONS
        const DATEREGEX       = "/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/";
	    const DATEREGEX2      = "/(19|20)\d\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])/";
        // LETNUMREGEX is used for database tables since SQL server won't convert 
        // hex encoded strings inside of brackets [] of table names.
        const LETNUMREGEX     = '/^[a-zA-Z0-9]+$/'; 
        const LETTERONLY      = '/[a-zA-Z]+$/';
        const NUMBERONLY      = '/[0-9]+$/';
        const NAMECHARS       = '/[a-zA-Z \-ÁáÉéÍíÑñÓóÚú]+$/';
        const ADDRESSCHARS    = '/[a-zA-Z0-9 \.\'\-ÁáÉéÍíÑñÓóÚú]+$/';
        const PASSWORDCHARS   = '/[a-zA-Z0-9@.!\-ÁáÉéÍíÑñÓóÚú]+$/';
        const EMAILADDRESS    = '/[a-zA-z0-9.-]+\@[a-zA-z0-9.-]+.[a-zA-Z]+$/';
        const PHONEREGEX      = '/[0-9 \-\+\(\)]+$/';
        //const COMPANYNAMEREGEX = '/[a-zA-Z \-\&\'ÁáÉéÍíÑñÓóÚú]+$/'; 
        
        // Converts user $_POST data to hexidecimal values that MS SQL Server
        // natively converts back to its original value. This is to prevent
        // SQL injection and should be used on every $_POST variable in the system.
        // Returns a hexidecimal number or int.
        public function mssql_escape($data)
        {
            // If the data is a number, there is no need to convert it
            if(is_numeric($data))
                return $data;

            $unpacked = unpack('H*hex', $data);

            return '0x' . $unpacked['hex'];
        }

        public function mssql_escape_int($data)
        {
            // If the data is a number, there is no need to convert it
            if(is_numeric($data))
                return "'" . $data . "'";

            $unpacked = unpack('H*hex', $data);

            return '0x' . $unpacked['hex'];
        }

        public function CleanAdmin($admin)
        {
            return $this -> mssql_escape($admin);
        }

        // Receives a state from the browser and stores that information in the SESSION.
        public function set_location($location)
        {
            // Change the state location from full name to its initial.
            $abvr = $this -> find_initials($location);
            
            // Check to see if state is null.
            if(isset($abvr))
            {
                // Start session to store session variables.
                session_start();

                // Set the long text location into session.
                $_SESSION["location"] = $location;
                
                // Set the state initials into session.
                $_SESSION["abvr"] = $abvr;
            }
        }

        // Gets the state initials when given the state's full name.
        // Returns a string or null if the state cannot be found.
        public function find_initials($state)
        {
            // If state is empty string, default case sets it to null.
            switch($state)
            {
                case "Alabama":	        return "AL";
                case "Alaska":          return "AK";
                case "Arizona":	        return "AZ";
                case "Arkansas":        return "AR";
                case "California":      return "CA";
                case "Colorado":        return "CO";
                case "Connecticut":     return "CT";
                case "Delaware":        return "DE";
                case "Florida":         return "FL";
                case "Georgia":         return "GA";
                case "Hawaii":          return "HA";
                case "Idaho":           return "ID";
                case "Illinois":        return "IL";
                case "Indiana":         return "IN";
                case "Iowa":            return "IA";
                case "Kansas":          return "KS";
                case "Kentucky":        return "KY";
                case "Louisiana":       return "LA";
                case "Maine":           return "ME";
                case "Maryland":        return "MD";
                case "Massachusetts":   return "MA";
                case "Michigan":        return "MI";
                case "Minnesota":       return "MN";
                case "Mississippi":     return "MS";
                case "Missouri":        return "MO";
                case "Montana":         return "MT";
                case "Nebraska":        return "NE";
                case "Nevada":          return "NV";
                case "New Hampshire":   return "NH";
                case "New Jersey":      return "NJ";
                case "New Mexico":      return "NM";
                case "New York":        return "NY";
                case "North Carolina":  return "NC";
                case "North Dakota":    return "ND";
                case "Ohio":            return "OH";
                case "Oklahoma":        return "OK";
                case "Oregon":          return "OR";
                case "Pennsylvania":    return "PA";
                case "Rhode Island":    return "RI";
                case "South Carolina":  return "SC";
                case "South Dakota":    return "SD";
                case "Tennessee":       return "TN";
                case "Texas":           return "TX";
                case "Utah":            return "UT";
                case "Vermont":         return "VT";
                case "Virginia":        return "VA";
                case "Washington":      return "WA";
                case "West Virginia":   return "WV";
                case "Wisconsin":       return "WI";
                case "Wyoming":         return "WY";
                default:                return null;
            }
        }

        public function FindFullName($initials)
        {
            // If state is empty string, default case sets it to null.
            switch(strtoupper($initials))
            {
                case "AL": return "Alabama";
                case "AK": return "Alaska";
                case "AZ": return "Arizona";
                case "AR": return "Arkansas";
                case "CA": return "California";
                case "CO": return "Colorado";
                case "CT": return "Connecticut";
                case "DE": return "Delaware";
                case "FL": return "Florida";
                case "GA": return "Georgia";
                case "HA": return "Hawaii";
                case "ID": return "Idaho";
                case "IL": return "Illinois";
                case "IN": return "Indiana";
                case "IA": return "Iowa";
                case "KS": return "Kansas";
                case "KY": return "Kentucky";
                case "LA": return "Louisiana";
                case "ME": return "Maine";
                case "MD": return "Maryland";
                case "MA": return "Massachusetts";
                case "MI": return "Michigan";
                case "MN": return "Minnesota";
                case "MS": return "Mississippi";
                case "MO": return "Missouri";
                case "MT": return "Montana";
                case "NE": return "Nebraska";
                case "NV": return "Nevada";
                case "NH": return "New Hampshire";
                case "NJ": return "New Jersey";
                case "NM": return "New Mexico";
                case "NY": return "New York";
                case "NC": return "North Carolina";
                case "ND": return "North Dakota";
                case "OH": return "Ohio";
                case "OK": return "Oklahoma";
                case "OR": return "Oregon";
                case "PA": return "Pennsylvania";
                case "RI": return "Rhode Island";
                case "SC": return "South Carolina";
                case "SD": return "South Dakota";
                case "TN": return "Tennessee";
                case "TX": return "Texas";
                case "UT": return "Utah";
                case "VT": return "Vermont";
                case "VA": return "Virginia";
                case "WA": return "Washington";
                case "WV": return "West Virginia";
                case "WI": return "Wisconsin";
                case "WY": return "Wyoming";
                default  :return null;
            }
        }
    }

?>