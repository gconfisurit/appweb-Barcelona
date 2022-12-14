<?php
//LLAMAMOS A LA CONEXION.
require_once '../../config/conexion.php';

class resumencobrorutas extends Conectar
{
    public function getcobros($fechai, $fechaf, $ruta, $tipo)
    {
        //LLAMAMOS A LA CONEXION QUE CORRESPONDA CUANDO ES SAINT: CONEXION2
        //CUANDO ES APPWEB ES CONEXION.
        $conectar = parent::conexion2();
        parent::set_names();

        //QUERY
        if ($tipo === 'B' and $ruta === 'Todos') {
            $sql = "SELECT EDV, 
              SUM(De_0_a_7_Dias) De_0_a_7_Dias, 
              SUM(De_8_a_14_Dias) De_8_a_14_Dias, 
              SUM(De_15_a_21_Dias) De_15_a_21_Dias,
              SUM(De_22_a_31_Dias) De_22_a_31_Dias,
              SUM(Mas_31_Dias) Mas_31_Dias,
              SUM(Total) Total
              FROM (
              select 
              c.CodVend EDV,
              case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 0 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 7 then
              p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
              else 0 end De_0_a_7_Dias,
              
              case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 8 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 14 then
              p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
              else 0 end De_8_a_14_Dias,
              
              case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 15 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 21 then
              p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
              else 0 end De_15_a_21_Dias,
              
              case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 22 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 31 then
              p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
              else 0 end De_22_a_31_Dias,
              
              case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 32 then
              p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
              else 0 end Mas_31_Dias,
              
              p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) Total
              
              from [BCONFISUR].[dbo].SAPAGCXC as p 
              inner join [BCONFISUR].[dbo].SAACXC as c on p.NroPpal = c.NroUnico 
              inner join [BCONFISUR].[dbo].SACLIE as cl on c.CodClie = cl.CodClie
              left join [BCONFISUR].[dbo].SAACXC as cxc on cxc.NumeroD = p.NumeroD and cxc.TipoCxc in ('10','20')
              where DATEADD(dd, 0, DATEDIFF(dd, 0, p.FechaE)) between '$fechai' and '$fechaf' and p.TipoCxc not in ('31','41')) AS TOTAL 
              GROUP BY EDV order by EDV asc";
        } else {
            if ($tipo === 'D' and $ruta === 'Todos') {
                $sql = "SELECT EDV, 
                    SUM(De_0_a_7_Dias) De_0_a_7_Dias, 
                    SUM(De_8_a_14_Dias) De_8_a_14_Dias, 
                    SUM(De_15_a_21_Dias) De_15_a_21_Dias,
                    SUM(De_22_a_31_Dias) De_22_a_31_Dias,
                    SUM(Mas_31_Dias) Mas_31_Dias,
                    SUM(Total) Total
                    FROM (
                    select 
                    c.CodVend EDV,
                    case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 0 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 7 then
                    p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                    else 0 end De_0_a_7_Dias,
                    
                    case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 8 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 14 then
                    p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                    else 0 end De_8_a_14_Dias,
                    
                    case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 15 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 21 then
                    p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                    else 0 end De_15_a_21_Dias,
                    
                    case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 22 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 31 then
                    p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                    else 0 end De_22_a_31_Dias,
                    
                    case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 32 then
                    p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                    else 0 end Mas_31_Dias,
                    
                    p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) Total
                    
                    from [BCONFISUR_D].[dbo].SAPAGCXC as p 
                    inner join [BCONFISUR_D].[dbo].SAACXC as c on p.NroPpal = c.NroUnico 
                    inner join [BCONFISUR_D].[dbo].SACLIE as cl on c.CodClie = cl.CodClie
                    left join [BCONFISUR_D].[dbo].SAACXC as cxc on cxc.NumeroD = p.NumeroD and cxc.TipoCxc in ('10','20')
                    where DATEADD(dd, 0, DATEDIFF(dd, 0, p.FechaE)) between '$fechai' and '$fechaf'  and p.TipoCxc not in ('31','41')) AS TOTAL 
                    GROUP BY EDV order by EDV asc";
            } else {
                if ($tipo === 'B' and $ruta != 'Todos') {
                    $sql = "SELECT EDV, 
                        SUM(De_0_a_7_Dias) De_0_a_7_Dias, 
                        SUM(De_8_a_14_Dias) De_8_a_14_Dias, 
                        SUM(De_15_a_21_Dias) De_15_a_21_Dias,
                        SUM(De_22_a_31_Dias) De_22_a_31_Dias,
                        SUM(Mas_31_Dias) Mas_31_Dias,
                        SUM(Total) Total
                        FROM (
                        select 
                        c.CodVend EDV,
                        case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 0 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 7 then
                        p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                        else 0 end De_0_a_7_Dias,
                        
                        case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 8 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 14 then
                        p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                        else 0 end De_8_a_14_Dias,
                        
                        case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 15 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 21 then
                        p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                        else 0 end De_15_a_21_Dias,
                        
                        case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 22 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 31 then
                        p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                        else 0 end De_22_a_31_Dias,
                        
                        case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 32 then
                        p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                        else 0 end Mas_31_Dias,
                        
                        p.Monto - isnull((select dev.Monto from [BCONFISUR].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) Total
                        
                        from [BCONFISUR].[dbo].SAPAGCXC as p 
                        inner join [BCONFISUR].[dbo].SAACXC as c on p.NroPpal = c.NroUnico 
                        inner join [BCONFISUR].[dbo].SACLIE as cl on c.CodClie = cl.CodClie
                        left join [BCONFISUR].[dbo].SAACXC as cxc on cxc.NumeroD = p.NumeroD and cxc.TipoCxc in ('10','20')
                        where DATEADD(dd, 0, DATEDIFF(dd, 0, p.FechaE)) between '$fechai' and '$fechaf' and  c.CodVend = '$ruta' and p.TipoCxc not in ('31','41')) AS TOTAL 
                        GROUP BY EDV order by EDV asc";
                } else {
                    if ($tipo === 'D' and $ruta != 'Todos') {
                        $sql = "SELECT EDV, 
                            SUM(De_0_a_7_Dias) De_0_a_7_Dias, 
                            SUM(De_8_a_14_Dias) De_8_a_14_Dias, 
                            SUM(De_15_a_21_Dias) De_15_a_21_Dias,
                            SUM(De_22_a_31_Dias) De_22_a_31_Dias,
                            SUM(Mas_31_Dias) Mas_31_Dias,
                            SUM(Total) Total
                            FROM (
                            select 
                            c.CodVend EDV,
                            case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 0 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 7 then
                            p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                            else 0 end De_0_a_7_Dias,
                            
                            case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 8 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 14 then
                            p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                            else 0 end De_8_a_14_Dias,
                            
                            case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 15 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 21 then
                            p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                            else 0 end De_15_a_21_Dias,
                            
                            case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 22 and DATEDIFF(day, cxc.FechaE, p.FechaE) <= 31 then
                            p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                            else 0 end De_22_a_31_Dias,
                            
                            case when DATEDIFF(day, cxc.FechaE, p.FechaE) >= 32 then
                            p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) 
                            else 0 end Mas_31_Dias,
                            
                            p.Monto - isnull((select dev.Monto from [BCONFISUR_D].[dbo].SAACXC as dev where dev.NroUnico = p.NroPpal and dev.TipoCxc in ('10','20')),0) Total
                            
                            from [BCONFISUR_D].[dbo].SAPAGCXC as p 
                            inner join [BCONFISUR_D].[dbo].SAACXC as c on p.NroPpal = c.NroUnico 
                            inner join [BCONFISUR_D].[dbo].SACLIE as cl on c.CodClie = cl.CodClie
                            left join [BCONFISUR_D].[dbo].SAACXC as cxc on cxc.NumeroD = p.NumeroD and cxc.TipoCxc in ('10','20')
                            where DATEADD(dd, 0, DATEDIFF(dd, 0, p.FechaE)) between '$fechai' and '$fechaf' and  c.CodVend = '$ruta' and p.TipoCxc not in ('31','41')) AS TOTAL 
                            GROUP BY EDV order by EDV asc";
                    }
                }
            }
        }

        //PREPARACION DE LA CONSULTA PARA EJECUTARLA.
        $sql = $conectar->prepare($sql);
        $sql->execute();
        $result = $sql->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
}
