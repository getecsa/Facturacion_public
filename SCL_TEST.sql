select mens.desc_menslin
from
FA_MENSAJES mens,
FA_MENSPROCESO procmen,
FA_HISTDOCU histdocu
where mens.corr_mensaje=procmen.corr_mensaje
and mens.cod_idioma=1
and mens.num_linea=1
and procmen.num_proceso=histdocu.num_proceso
and histdocu.num_proceso  =4847121;


SELECT * from FA_HISTDOCU where   NUM_SECUREL='919215'

// codigo de cliente,leyenda del doc, folio factura origen, razon social, monto total fac origen,fechaemision, 
SELECT COD_CLIENTE, TOT_CARGOSME, FEC_EMISION, (
      SELECT mens.desc_menslin
        FROM
             FA_MENSAJES mens,
             FA_MENSPROCESO procmen,
             FA_HISTDOCU histdocu
       where mens.corr_mensaje=procmen.corr_mensaje
         and mens.cod_idioma=1
         and mens.num_linea=1
         and procmen.num_proceso=histdocu.num_proceso
         and histdocu.num_proceso  =his.NUM_PROCESO) as LEYENDA_DOC,
     (SELECT NOM_CLIENTE ||' ' ||
             NOM_APECLIEN1||' '||
             NOM_APECLIEN2
        FROM GE_CLIENTES
       WHERE COD_CLIENTE=his.COD_CLIENTE
  AND ROWNUM <= 1) as RAZON_SOCIAL,
  (SELECT CASE WHEN sum(TOT_CARGOSME) !=0  THEN SUM(TOT_CARGOSME)
              ELSE 0 END AS "TOTAL" 
     FROM FA_HISTDOCU 
    WHERE NUM_SECUREL=his.NUM_SECUREL and COD_TIPDOCUM='25' and cod_cliente =his.COD_CLIENTE) as TOTAL_NOTAS
from FA_HISTDOCU his where PREF_PLAZA='DFFFM' AND NUM_FOLIO='4752';


total de notas de creditos generadas SUM(TOT_CARGOSME)
SELECT SUM(TOT_CARGOSME) FROM FA_HISTDOCU WHERE NUM_SECUREL='919215' and COD_TIPDOCUM='25' and cod_cliente ='2684842';


SELECT CASE WHEN sum(TOT_CARGOSME) !=0  THEN SUM(TOT_CARGOSME)
                   ELSE 0
              END AS "TOTAL" FROM FA_HISTDOCU WHERE NUM_SECUREL='919215' and COD_TIPDOCUM='25' and cod_cliente ='2684842';



SELECT * from FA_HISTDOCU WHERE cod_cliente ='2684842' AND NUM_SECUREL='919215';

//saberlos conceptos de la factura
select * from fa_histconc_19010102 where ind_ordentotal = '39353304'