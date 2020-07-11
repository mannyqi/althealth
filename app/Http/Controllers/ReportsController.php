<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use DB;

class ReportsController extends Controller
{
    /**
     * Day-2-day report - unpaid invoices
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Original
        $reports = DB::select("SELECT inv.Client_id AS 'CLIENT_ID',
                                    CONCAT(cl.C_name, ' ', cl.C_surname) AS 'CLIENT',
                                    inv.Inv_Num AS 'INVOICE_NUMBER',
                                    inv.Inv_Date AS 'INVOICE_DATE'
                                FROM tblinv_info inv
                                INNER JOIN tblclientinfo cl ON cl.Client_id = inv.Client_id
                                WHERE YEAR(inv.Inv_Date) < YEAR(CURDATE()) AND inv.Inv_Paid <> 'Y'
                                ORDER BY inv.Inv_Num
                                ");

        return view('reports.d2d-1')->with('reports', $reports);
    }

    /**
     * Day-2-day report - Client birthdays for current day
     *
     * @return \Illuminate\Http\Response
     */
    public function d2d2()
    {
        // Original
        $reports = DB::select("SELECT DISTINCT
                                inv.Client_id AS 'CLIENT_ID',
                                CONCAT(cl.C_name, ' ', cl.C_surname) AS 'CLIENT_NAME'
                                FROM tblinv_info inv
                                INNER JOIN tblclientinfo cl on cl.Client_id = inv.Client_id
                                WHERE SUBSTR(inv.Client_id, 3, 2) = MONTH(CURRENT_DATE())
                                AND SUBSTR(inv.Client_id, 5, 2) = DAY(CURRENT_DATE())");

        return view('reports.d2d-2')->with('reports', $reports);
    }

    /**
     * Day-2-day report - Client birthdays for current day
     *
     * @return \Illuminate\Http\Response
     */
    public function d2d3()
    {
        // Original
        $reports = DB::select("SELECT sup.Supplement_id AS 'SUPPLEMENT',
                                    CONCAT(si.Supplier_id, ' ', si.Contact_Person, ' ', si.Supplier_Tel) AS 'SUPPLIER_INFORMATION',
                                    sup.Min_levels AS 'MIN_LEVELS',
                                    sup.Current_stock_levels AS 'CURRENT_STOCK'
                                FROM tblsupplier_info si
                                INNER JOIN tblsupplements sup ON sup.Supplier_id = si.Supplier_id
                                WHERE sup.Current_stock_levels < sup.Min_levels
                                ORDER BY sup.Supplier_id
                                ");

        return view('reports.d2d-3')->with('reports', $reports);
    }

    /**
     * MIS report 1 - Top 10 clients within a period of time
     *
     * @return \Illuminate\Http\Response
     */
    public function mis1()
    {
        // Original
        $reports = DB::select("SELECT
                                    CONCAT(inv.Client_id, ' ', cl.C_name, ' ', cl.C_surname) AS 'CLIENT',
                                    COUNT(inv.Client_id) AS 'FREQUENCY'
                                FROM tblclientinfo cl
                                INNER JOIN tblinv_info inv ON inv.Client_id = cl.Client_id
                                WHERE YEAR(inv.Inv_Date) >= 2018 AND YEAR(inv.Inv_Date) <= 2019
                                GROUP BY 1
                                ORDER BY 2 desc
                                LIMIT 10
                                ");

        return view('reports.mis-1')->with('reports', $reports);
    }

    /**
     * MIS report 2 - Number of purchases by month
     *
     * @return \Illuminate\Http\Response
     */
    public function mis2()
    {
        // Original
        $reports = DB::select("SELECT
                                count(extract(month from Inv_Date)) 'NUM_OF_PURCHASES',
                                monthname(Inv_Date) 'MONTH'
                                FROM tblinv_info
                                GROUP BY MONTH
                                ORDER BY extract(month from Inv_Date)");

        return view('reports.mis-2')->with('reports', $reports);
    }

    /**
     * MIS report 3 - Missing contact info
     *
     * @return \Illuminate\Http\Response
     */
    public function mis3()
    {
        // Original
        $reports = DB::select("SELECT
                                Client_id AS 'CLIENT',
                                C_Tel_H AS 'HOME',
                                C_Tel_W AS 'WORK',
                                C_Tel_Cell AS 'CELL',
                                C_Email AS 'EMAIL'
                                FROM tblclientinfo
                                WHERE C_Email = '' AND C_Tel_Cell = ''");

        return view('reports.mis-3')->with('reports', $reports);
    }

}
