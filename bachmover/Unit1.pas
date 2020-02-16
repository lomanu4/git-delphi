﻿unit Unit1;

interface

uses
  System.SysUtils, System.Types, System.UITypes, System.Classes,
  System.Variants,
  FMX.Types, FMX.Controls, FMX.Forms, FMX.Graphics, FMX.Dialogs,
  FireDAC.Stan.Intf, FireDAC.Stan.Option, FireDAC.Stan.Error, FireDAC.UI.Intf,
  FireDAC.Phys.Intf, FireDAC.Stan.Def, FireDAC.Stan.Pool, FireDAC.Stan.Async,
  FireDAC.Phys, FireDAC.FMXUI.Wait, FireDAC.Stan.Param, FireDAC.DatS,
  FireDAC.DApt.Intf, FireDAC.DApt, REST.Types, Data.Bind.EngExt,
  FMX.Bind.DBEngExt, FMX.TMSLiveGridDataBinding, System.Rtti,
  System.Bindings.Outputs, FMX.Bind.Editors, FireDAC.Comp.BatchMove.DataSet,
  FireDAC.Comp.BatchMove, Data.Bind.Components, Data.Bind.Grid,
  Data.Bind.DBScope, FireDAC.Comp.Client, REST.Response.Adapter, REST.Client,
  Data.Bind.ObjectScope, Data.DB, FireDAC.Comp.DataSet, FMX.TMSBaseControl,
  FMX.TMSGridCell, FMX.TMSGridOptions, FMX.TMSGridData, FMX.TMSCustomGrid,
  FMX.TMSLiveGrid, FireDAC.Phys.SQLite, FireDAC.Phys.SQLiteDef,
  FireDAC.Stan.ExprFuncs, FMX.Controls.Presentation, FMX.StdCtrls,
  FireDAC.Comp.BatchMove.SQL, FireDAC.Stan.StorageJSON, FireDAC.Comp.UI,
  System.JSON,
  FMX.Bind.Grid, FMX.Grid.Style, FMX.ScrollBox, FMX.Grid, Data.Bind.Controls,
  FMX.Layouts, FMX.Bind.Navigator, FMX.Memo;

type
  TForm1 = class(TForm)
    TMSFMXLiveGrid1: TTMSFMXLiveGrid;
    RESTClient1: TRESTClient;
    RESTRequest1: TRESTRequest;
    RESTResponse1: TRESTResponse;
    RESTResponseDataSetAdapter1: TRESTResponseDataSetAdapter;
    FDMemTable1: TFDMemTable;
    BindSourceDB1: TBindSourceDB;
    BindingsList1: TBindingsList;
    BindSourceDB2: TBindSourceDB;
    FDBatchMoveDataSetReader1: TFDBatchMoveDataSetReader;
    FDPhysSQLiteDriverLink1: TFDPhysSQLiteDriverLink;
    Button1: TButton;
    FDBatchMove1: TFDBatchMove;
    FDMemTable1id: TWideStringField;
    FDMemTable1Materiale: TWideStringField;
    FDMemTable1Descripzione: TWideStringField;
    FDMemTable1Quantita: TWideStringField;
    FDMemTable1Treno: TWideStringField;
    FDMemTable1Discorta: TWideStringField;
    FDMemTable1Commento: TWideStringField;
    FDMemTable1Data: TWideStringField;
    FDMemTable1Creatoda: TWideStringField;
    FDMemTable1Ordinato: TWideStringField;
    LinkGridToDataSourceBindSourceDB1: TLinkGridToDataSource;
    FDBatchMoveSQLWriter1: TFDBatchMoveSQLWriter;
    FDStanStorageJSONLink1: TFDStanStorageJSONLink;
    FDGUIxWaitCursor1: TFDGUIxWaitCursor;
    Button2: TButton;
    Button3: TButton;
    StringGrid1: TStringGrid;
    BindSourceDB5: TBindSourceDB;
    FDConnection1: TFDConnection;
    FDTable1: TFDTable;
    FDTable1ID: TFDAutoIncField;
    FDTable1MATERIALE: TWideMemoField;
    FDTable1DESCRIPZIONE: TWideMemoField;
    FDTable1QUANTITA: TWideMemoField;
    FDTable1TRENO: TBlobField;
    FDTable1DISCORTA: TWideMemoField;
    FDTable1COMMENTO: TWideMemoField;
    FDTable1DATA: TWideMemoField;
    FDTable1CREATODA: TWideMemoField;
    FDTable1ORDINATO: TWideMemoField;
    BindSourceDB6: TBindSourceDB;
    LinkGridToDataSourceBindSourceDB6: TLinkGridToDataSource;
    AniIndicator1: TAniIndicator;
    BindSourceDB3: TBindSourceDB;
    Button4: TButton;
    ProgressBar1: TProgressBar;
    Memo1: TMemo;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
    procedure Button3Click(Sender: TObject);
    procedure FormCreate(Sender: TObject);
    procedure Button4Click(Sender: TObject);
    procedure StringGrid1DrawColumnCell(Sender: TObject; const Canvas: TCanvas;
      const Column: TColumn; const Bounds: TRectF; const Row: Integer;
      const Value: TValue; const State: TGridDrawStates);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

type
  TTupdate = class(TThread)
  private
    { Private declarations }
  protected
    procedure Execute; override;
  public
    procedure sync;
    procedure insert;
    constructor Create(CreateSuspended: Boolean); // конструктор потока
  end;

var
  Form1: TForm1;
  Update: TTupdate;
  Request: TRESTRequest;
  Client: TRESTClient;
  Response: TRESTResponse;
  Adapter: TRESTResponseDataSetAdapter;
  aggiornarichiesta: TJSONObject;

implementation

{$R *.fmx}

procedure TForm1.Button1Click(Sender: TObject);

begin
  FDConnection1.Connected := False;
  // FDTable1.Close;
  FDBatchMoveSQLWriter1.Connection := FDConnection1;
  FDBatchMoveSQLWriter1.TableName := 'Richiesta';
  FDBatchMoveDataSetReader1.DataSet := FDMemTable1;
  RESTRequest1.Execute;
  FDBatchMove1.Execute;
  FDTable1.Filter:='Ordinato='+QuotedStr('Si') ;
  FDTable1.Filtered:=True;
  FDConnection1.Connected := True;
  FDTable1.Active := True;



end;

procedure TForm1.Button2Click(Sender: TObject);
begin
  RESTRequest1.Execute;
end;

procedure TForm1.Button3Click(Sender: TObject);
var
  aggiornarichiesta: TJSONObject;
  i, b: Integer;
  a: TStream;
begin

  try
    FDTable1.First;
    for i := 0 to FDTable1.RecordCount do
    begin
      if RESTRequest1.Response.StatusCode = 200 then
        RESTRequest1.ClearBody;
      RESTClient1.BaseURL := 'http://localhost/loman/dati.php';
      // RESTRequest1.Params[0].Name := 'ID';
      //
      //
      // RESTRequest1.Params[1].Name := 'Materiale';
      //
      //
      //
      // RESTRequest1.Params[2].Name := 'Descripzione';
      //
      //
      // RESTRequest1.Params[3].Name := 'Quantita';
      //
      //
      // RESTRequest1.Params[4].Name := 'Treno';
      //
      //
      // RESTRequest1.Params[5].Name := 'Discorta';
      //
      // RESTRequest1.Params[6].Name := 'Commento';
      //
      //
      // RESTRequest1.Params[7].Name := 'Creatoda';
      //
      //
      // RESTRequest1.Params[8].Name := 'Ordinato';

      RESTRequest1.Execute;
      aggiornarichiesta := TJSONObject.Create;
      aggiornarichiesta.AddPair('id', FDTable1ID.Text);
      aggiornarichiesta.AddPair('Materiale', FDTable1.FieldByName('Materiale')
        .AsString);
      aggiornarichiesta.AddPair('Descripzione',
        FDTable1.FieldByName('Descripzione').AsString);
      aggiornarichiesta.AddPair('Quantita', FDTable1.FieldByName('Quantita')
        .AsString);
      aggiornarichiesta.AddPair('Treno', FDTable1.FieldByName('Treno')
        .AsString);
      aggiornarichiesta.AddPair('Discorta', FDTable1.FieldByName('Discorta')
        .AsString);
      aggiornarichiesta.AddPair('Commento', FDTable1.FieldByName('Commento')
        .AsString);
      aggiornarichiesta.AddPair('Creatoda', FDTable1.FieldByName('Creatoda')
        .AsString);
      aggiornarichiesta.AddPair('Ordinato', FDTable1.FieldByName('Ordinato')
        .AsString);
      RESTClient1.BaseURL := 'http://localhost/loman/Product/update.php';
      RESTRequest1.ClearBody;
      RESTRequest1.AddBody(aggiornarichiesta.ToString,
        ContentTypeFromString('application/json'));
      RESTRequest1.Execute;
      FDTable1.Next;
      if FDTable1.Eof then
      begin
        ShowMessage('ok');
        // RESTRequest1.ClearBody;
        // RESTClient1.BaseURL := 'http://localhost/loman/dati.php';
        // RESTRequest1.Execute;
      end;
    end;
  finally
    RESTRequest1.DisposeOf;
  end;

end;

procedure TForm1.Button4Click(Sender: TObject);
begin


    update := TTupdate.Create(False);
    Update.Priority:=tpNormal;
    Button4.Enabled:=False;
end;

procedure TForm1.FormCreate(Sender: TObject);
begin
  // FDTable1.First;
end;

procedure TForm1.StringGrid1DrawColumnCell(Sender: TObject;
  const Canvas: TCanvas; const Column: TColumn; const Bounds: TRectF;
  const Row: Integer; const Value: TValue; const State: TGridDrawStates);
begin
if FDTable1.FieldByName('Ordinato').AsString = 'No' then


end;

{ TThread }
constructor TTupdate.Create(CreateSuspended: Boolean);

begin
  inherited Create(CreateSuspended);

end;

procedure TTupdate.Execute;
var
  i: Integer;
    bookmark: TBookmark;

begin
  try


    inherited;
    Client := TRESTClient.Create(nil);
    Request := TRESTRequest.Create(nil);
    Response := TRESTResponse.Create(nil);
    Adapter := TRESTResponseDataSetAdapter.Create(nil);
    Adapter.Response := Response;
    Adapter.DataSet := Form1.FDMemTable1;
    Request.Client := Client;
    Request.Response := Response;
    Client.Accept := 'application/json, text/plain; q=0.9, text/html;q=0.8,';
    Client.AcceptCharset := 'utf-8, *;q=0.8';
    Client.BaseURL := 'http://localhost/loman/dati.php';
    Request.Method := rmGET;
    Form1.ProgressBar1.Max := Form1.FDTable1.RecordCount;
    //Form1.FDTable1.DisableControls;
    try
       bookmark := Form1.FDTable1.Bookmark;
       Form1.FDTable1.First;
      while not  Form1.FDTable1.eof do     // сделать если не с выбрной строчки тогда проходимся повсему
      begin
        aggiornarichiesta := TJSONObject.Create;
        aggiornarichiesta.AddPair('id', Form1.FDTable1ID.Text);
        aggiornarichiesta.AddPair('Materiale',
          Form1.FDTable1.FieldByName('Materiale').AsString);
        aggiornarichiesta.AddPair('Descripzione',
          Form1.FDTable1.FieldByName('Descripzione').AsString);
        aggiornarichiesta.AddPair('Quantita',
          Form1.FDTable1.FieldByName('Quantita').AsString);
        aggiornarichiesta.AddPair('Treno', Form1.FDTable1.FieldByName('Treno')
          .AsString);
        aggiornarichiesta.AddPair('Discorta',
          Form1.FDTable1.FieldByName('Discorta').AsString);
        aggiornarichiesta.AddPair('Commento',
          Form1.FDTable1.FieldByName('Commento').AsString);
        aggiornarichiesta.AddPair('Creatoda',
          Form1.FDTable1.FieldByName('Creatoda').AsString);
        aggiornarichiesta.AddPair('Ordinato',
          Form1.FDTable1.FieldByName('Ordinato').AsString);
        Client.BaseURL := 'https://lucera.myds.me/loman/dati.php';
        Request.ClearBody;
        Request.AddBody(aggiornarichiesta.ToString,
          ContentTypeFromString('application/json'));
        Synchronize(sync);

        Form1.FDTable1.Next;
      end;
    finally
         Form1.Memo1.Lines.Add('Finish') ;
          Form1.FDTable1.Bookmark := bookmark;
        Form1.Button4.Enabled:=True;
        Form1.FDTable1.EnableControls ;
        update.free
    end;

  finally
        Form1.Memo1.Lines.Add('Finish1') ;


  end;
  // Request.Response.RawBytes
  // if Form1.FDTable1.Bof then
  // begin
  // ShowMessage('ok');
  //
  // Form1.RESTClient1.BaseURL := 'http://localhost/loman/dati.php';
  // Form1.RESTRequest1.Execute;
  //
  // end;

end;

procedure TTupdate.insert;
begin
  //

end;

procedure TTupdate.sync;
begin
  Request.Execute;
end;

end.
