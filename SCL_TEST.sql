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

SELECT * from FA_HISTDOCU where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='4752';

// codigo de cliente,leyenda del doc, folio factura origen, razon social, monto total fac origen,fechaemision, 
SELECT COD_CLIENTE, TOT_CARGOSME, FEC_EMISION, IND_ORDENTOTAL, (
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
              ELSE 0 END 
     FROM FA_HISTDOCU 
    WHERE NUM_SECUREL=his.NUM_SECUENCI and COD_TIPDOCUM='25' and cod_cliente =his.COD_CLIENTE) as TOTAL_NOTA
from FA_HISTDOCU his where PREF_PLAZA='DFFFM' AND NUM_FOLIO='4752';


total de notas de creditos generadas SUM(TOT_CARGOSME)
SELECT SUM(TOT_CARGOSME) FROM FA_HISTDOCU WHERE NUM_SECUREL='919215' and COD_TIPDOCUM='25' and cod_cliente ='2684842';


SELECT CASE WHEN sum(TOT_CARGOSME) !=0  THEN SUM(TOT_CARGOSME)
                   ELSE 0
              END AS "TOTAL" FROM FA_HISTDOCU WHERE NUM_SECUREL='919215' and COD_TIPDOCUM='25' and cod_cliente ='2684842';

SELECT * from FA_HISTDOCU WHERE cod_cliente ='2684842' AND NUM_SECUREL='919215';

//saberlos conceptos de la factura---
select * from fa_histconc_19010102 where ind_ordentotal = '134694192'

select  * from fa_histdocu where pref_plaza = 'DFFFM' AND NUM_FOLIO = 700108


// obtener los impuestos y ieps de los conceptos que tiene en esa factura

SELECT his2.COD_CONCEPTO, his2.DES_CONCEPTO, his2.COD_CONCEREL
  FROM fa_histconc_19010102 his2 
 where his2.ind_ordentotal = '134694192' and his2.COD_CONCEREL > '0'

 
//valores de los impuestos 
select * from FA_Conceptos
where cod_concepto IN (11440,11438,11442)

//obtener solo el concepto descripcion e importe de la factura

select COD_CONCEPTO, DES_CONCEPTO, IMP_CONCEPTO AS IMPORTE_TOTAL 
  from fa_histconc_19010102 his 
 where ind_ordentotal = '136649114' and COD_CONCEREL < '0'

select ind_ordentotal
                                                                  from fa_histdocu
                                                                 where num_securel =
                                                                             (SELECT num_secuenci
                                                                                from FA_HISTDOCU
                                                                               where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319')
                                                                   and cod_tipdocum = 25
                                                                   and cod_cliente =
                                                                             (SELECT cod_cliente
                                                                                from FA_HISTDOCU
                                                                               where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319')





//OBTENER TOTAL DE LAS NOTAS DE CREDITO
SELECT * from FA_HISTDOCU where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319';
select * from fa_histdocu where num_securel = 1745746 and cod_tipdocum = 25 and cod_cliente =64841416

select COD_CONCEPTO, DES_CONCEPTO, IMP_CONCEPTO AS IMPORTE_TOTAL 
  from fa_histconc_19010102 his 
 where ind_ordentotal = '136649184' and COD_CONCEREL < '0'

select IMP_CONCEPTO  
  from fa_histconc_19010102 his 
 where ind_ordentotal = '136649184' and COD_CONCEREL < '0' and COD_CONCEPTO = '734'
   
SELECT CASE WHEN sum(TOT_CARGOSME) !=0  THEN SUM(TOT_CARGOSME)
      ELSE 0
      END AS "TOTAL" 
  FROM FA_HISTDOCU 
 WHERE NUM_SECUREL='919215' and COD_TIPDOCUM='25' and cod_cliente ='2684842';
 


SELECT INT_ORDENTOTAL from FA_HISTDOCU where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319' 

///// obtener notas de creditos existentes

SELECT num_secuenci, cod_cliente from FA_HISTDOCU where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319';

SELECT * from FA_HISTDOCU where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319';


select * 
  from fa_histdocu 
 where num_securel = 
             (SELECT num_secuenci 
                from FA_HISTDOCU 
               where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319') 
   and cod_tipdocum = 25 
   and cod_cliente =
             (SELECT cod_cliente 
                from FA_HISTDOCU 
               where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319')



SELECT num_secuenci from FA_HISTDOCU where  PREF_PLAZA='DFFFM' AND NUM_FOLIO='705319';

  
//obtener los conceptos de cada nota de credito generada y saber que conceptos tienen disponible a la factura origen

select COD_CONCEPTO, DES_CONCEPTO, IMP_CONCEPTO AS IMPORTE_TOTAL 
  from fa_histconc_19010102 his 
 where ind_ordentotal = '136649184' and COD_CONCEREL < '0'

select *
  from fa_histconc_19010102 his 
 where ind_ordentotal = '136649184' and COD_CONCEREL < '0' and cod_concepto = '734'

//OBTENGO FACTURA
  SELECT 
         (select COD_CONCEPTO, DES_CONCEPTO, IMP_CONCEPTO AS IMPORTE_TOTAL 
            from fa_histconc_19010102 his2 
           where HIS2.ind_ordentotal = HIS1.IND_ORDENTOTAL and his2.COD_CONCEREL < '0')
    from FA_HISTDOCU HIS1
   where  HIS1.PREF_PLAZA='DFFFM' AND HIS1.NUM_FOLIO='705319'; 
   
   left join ALL_TAB_COLUMNS ATC2 on ATC1.COLUMN_NAME = ATC1.COLUMN_NAME 
   
//OBTENGO CONCEPTOS DE FACTURA
select COD_CONCEPTO, DES_CONCEPTO, IMP_CONCEPTO AS IMPORTE_TOTAL 
  from fa_histconc_19010102 his 
 where ind_ordentotal = '136649184' and COD_CONCEREL < '0'
//OBTENGO SUMATORIA DE CADA UNO DE LOS CONCEPTOS DE LAS NOTAS DE CREDITOS EXISTENTES

//OBTENGO NOTAS DE CREDITO
select * from fa_histdocu where num_securel = 1745746 and cod_tipdocum = 25 and cod_cliente =64841416 

SELECT * FROM FA_HISTCONC_19010102 WHERE IND_ORDENTOTAL='136649184' AND COD_CONCEREL < '0' AND COD_CONCEPTO='734'


select COD_CONCEPTO
                                           from fa_histconc_19010102 his
                                          where ind_ordentotal = '39353304' and COD_CONCEREL < '0'
